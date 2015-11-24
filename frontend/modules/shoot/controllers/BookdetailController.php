<?php

namespace frontend\modules\shoot\controllers;

use common\models\shoot\searchs\ShootBookdetailSearch;
use common\models\shoot\ShootAppraise;
use common\models\shoot\ShootAppraiseResult;
use common\models\shoot\ShootAppraiseTemplate;
use common\models\shoot\ShootAppraiseWork;
use common\models\shoot\ShootBookdetail;
use wskeee\framework\FrameworkManager;
use wskeee\rbac\RbacManager;
use wskeee\rbac\RbacName;
use wskeee\utils\DateUtil;
use Yii;
use yii\base\Exception;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * BookdetailController implements the CRUD actions for ShootBookdetail model.
 */
class BookdetailController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ShootBookdetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        /* @var $fwManager FrameworkManager */
        $fwManager = \Yii::$app->get('fwManager');
        
        $date=  isset(Yii::$app->request->queryParams['date']) ? 
                date('Y-m-d',strtotime(Yii::$app->request->queryParams['date'])) : date('Y-m-d');
        
        //目标周的起始日期
        $se = DateUtil::getWeekSE($date);
        $dataProvider = ShootBookdetailSearch::find()
                ->where('book_time >= '.strtotime($se['start']))
                ->andWhere('book_time <= '.strtotime($se['end']))
                ->orderBy('book_time')
                ->with('teacher')
                ->with('contacter')
                ->with('booker')
                ->with('shootMan')
                ->all();
        $indexOffsetTimes = [
            '9 hours',
            '14 hours',
            '18 hours',
        ];
        //创建一周空数据
        $weekdatas = [];
        for($i=0,$len=7;$i<$len;$i++)
        {
            for($index=0;$index<3;$index++)
            {
                $weekdatas[] = new ShootBookdetailSearch([
                    'site_id' => 1,
                    'book_time' => strtotime($se['start'].' +'.($i).'days '.$indexOffsetTimes[$index]),
                    'index' => $index,
                ]);
            }
        };
        
        $startIndex = 0;
        foreach ($dataProvider as $model)
        {
            for($i = $startIndex,$len=count($weekdatas);$i<$len;$i++)
            {
                if($weekdatas[$i]->book_time == $model->book_time)
                {
                    $weekdatas[$i] = $model;
                    $startIndex = $i+1;
                    break;
                }
            }
        }
        
        $bids = ArrayHelper::getColumn($dataProvider, 'id');
        $query = new Query();
        $row = $query->select('*')
                ->from(['a'=> ShootAppraiseResult::tableName()])
                ->where(['b_id'=>$bids])
                ->all();
        \Yii::trace($row);
        
        return $this->render('index', [
            'dataProvider' => new ArrayDataProvider([
                'allModels' => $weekdatas,
                'sort' => [
                            'attributes' => ['book_time'],
                        ],
                        'pagination' => [
                            'pageSize' => 21,
                        ],
                            ]),
            'date' => $date,
            'prevWeek' => DateUtil::getWeekSE($date,-1)['start'],
            'nextWeek' => DateUtil::getWeekSE($date,1)['start'],
        ]);
    }

    /**
     * Displays a single ShootBookdetail model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'shootmans' => $this->isRole(RbacName::ROLE_SHOOT_LEADER) ?
                            $this->getRoleToUsers(RbacName::ROLE_SHOOT_MAN) : [],
        ]);
    }

    /**
     * Creates a new ShootBookdetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can(RbacName::PERMSSIONT_SHOOT_CREATE))
            throw new UnauthorizedHttpException('无权操作！');
        
        $model = new ShootBookdetail();
        $model->loadDefaultValues();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $this->saveNewBookdetail($model);
            
            return $this->redirect([
                'view', 'id' => $model->id
                    ]);
        } else {
            $model->status = ShootBookdetail::STATUS_BOOKING;
            $model->u_booker = Yii::$app->user->id;
            $model->u_contacter = Yii::$app->user->id;
            $post = Yii::$app->getRequest()->getQueryParams();
            if(isset($post['site_id']))
                $model->site_id = $post['site_id'];
            if(isset($post['book_time']))
                $model->book_time = $post['book_time'];
            if(isset($post['index']))
                $model->index = $post['index'];
            return $this->render('create', [
                'model' => $model,
                'users' => $this->getRoleToUsers(RbacName::ROLE_WD),
                'colleges' => $this->getCollegesForSelect(),
                'projects' => [],
                'courses' => [],
            ]);
        }
    }
    
    /**
     * 
     * @param ShootBookdetail $model
     */
    private function saveNewBookdetail($model)
    {
        $trans = \Yii::$app->db->beginTransaction();
        try
        {
            $model->status = ShootBookdetail::STATUS_ASSIGN;
            
            if(!$model->save())
                throw new Exception(json_encode($model->getErrors()));
            
            $work = new ShootAppraiseWork(['b_id'=>$model->id]);
            if(!$work->save(ShootAppraiseTemplate::find()->asArray()->all()))
                throw new Exception(json_encode($model->getErrors()));
            
            $trans->commit();
        } catch (\Exception $ex) {
            $trans ->rollBack();
            
            throw new NotFoundHttpException("保存任务失败！".$ex->getMessage()); 
        }
    }

    /**
     * Updates an existing ShootBookdetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'users' => $this->getRoleToUsers(RbacName::ROLE_WD),
                'colleges' => $this->getCollegesForSelect(),
                'projects' => $this->getFwItemForSelect($model->fw_college),
                'courses' => $this->getFwItemForSelect($model->fw_project),
            ]);
        }
    }

    /**
     * Deletes an existing ShootBookdetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    /**
     * 指派摄影师
     * @param int $id           任务id
     * @param int $shoot_man_id 指派摄影师id
     */
    public function actionAssign($id)
    {
        $model = $this->findModel($id);
        try
        {
            if($model->load(\Yii::$app->getRequest()->post()) && $model->validate());
            {
                $model->status = $model->u_shoot_man == null ? ShootBookdetail::STATUS_ASSIGN : ShootBookdetail::STATUS_SHOOTING;
                $model->save();
                Yii::$app->getSession()->setFlash('success','操作成功！');
            }
        } catch (\Exception $ex) {
            Yii::$app->getSession()->setFlash('error','操作失败::'.$ex->getMessage());
        }
        
        $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Finds the ShootBookdetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShootBookdetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = ShootBookdetail::find()
                ->where(['id'=>$id])
                ->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function getCollegesForSelect()
    {
        /* @var $fwManager FrameworkManager */
        $fwManager = \Yii::$app->get('fwManager');
        return ArrayHelper::map($fwManager->getColleges(), 'id', 'name');
    }
    
    /**
     * 获取项目
     * @param int $itemId
     */
    protected function getFwItemForSelect($itemId)
    {
        /* @var $fwManager FrameworkManager */
        $fwManager = \Yii::$app->get('fwManager');
        return ArrayHelper::map($fwManager->getChildren($itemId), 'id', 'name');
    }


    /**
     * 获取角色的用户
     */
    protected function getRoleToUsers($roleName)
    {
        /* @var $rbacManager RbacManager */
        $rbacManager = \Yii::$app->authManager;
        return ArrayHelper::map($rbacManager->getItemUsers($roleName), 'id', 'nickname');
    }
    
    protected function isRole($roleName)
    {
        /* @var $rbacManager RbacManager */
        $rbacManager = \Yii::$app->authManager;
        return $rbacManager->isRole($roleName, Yii::$app->user->id);
    }
}
