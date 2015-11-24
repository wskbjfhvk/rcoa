<?php

namespace frontend\modules\shoot\controllers;

use common\models\shoot\searchs\ShootAppraiseSearch;
use common\models\shoot\ShootAppraise;
use common\models\shoot\ShootAppraiseResult;
use common\models\shoot\ShootAppraiseWork;
use common\models\shoot\ShootBookdetail;
use wskeee\rbac\RbacName;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;

/**
 * AppraiseController implements the CRUD actions for ShootAppraise model.
 */
class AppraiseController extends Controller
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
            'access' => [
                'class' =>  AccessControl::className(),
                'rules' =>  [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all ShootAppraise models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShootAppraiseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShootAppraise model.
     * @param integer $b_id
     * @param integer $u_id
     * @return mixed
     */
    public function actionView($b_id, $u_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($b_id, $u_id),
        ]);
    }

    /**
     * 创建评价
     * @param int $b_id 任务id
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $b_id = Yii::$app->getRequest()->getQueryParam('b_id');
        $work = new ShootAppraiseWork(['b_id'=>$b_id ]);
        
        $bookdetail = $this->findBookdetail($b_id);
        $appraises = $work->find();
        $results = ShootAppraiseResult::findAll(['b_id'=>$b_id ]);
        
        return $this->render('create', [
                    'bookdetail' => $bookdetail,
                    'appraises' => $appraises,
                    'results' => $results,
                    'b_id' => $b_id
        ]);
    }
    
    public function actionAdd()
    {
        $post = Yii::$app->request->post();
        /** $b_id 任务id */
        $b_id = $post['b_id'];
        /** 用户id */
        $u_id = \Yii::$app->user->id;
        
        if(!Yii::$app->user->can(RbacName::PERMSSIONT_SHOOT_APPRAISE,['job'=>$this->findBookdetail($b_id)]))
            throw new NotAcceptableHttpException("无权限操作！");
        
        $tran = \Yii::$app->db->beginTransaction();
        $values = [];
        foreach($post as $key => $value)
        {
            if($key != '_csrf' && $key != 'b_id')
            {
                $key_arr = explode('-', $key);
                $values[] = [$b_id,$u_id,$key_arr[0],$key_arr[1],$value];
            }
        }
        try {
            /** 清除先前记录 */
            \Yii::$app->db->createCommand()->delete(ShootAppraiseResult::tableName(), [
                'b_id' => $b_id,
                'u_id' => $u_id,
            ])->execute();
            
            /** 添加新记录 */
            \Yii::$app->db->createCommand()->batchInsert(ShootAppraiseResult::tableName(), 
            [
                'b_id',
                'u_id',
                'role_name',
                'q_id',
                'value',
            ], $values)->execute();
            $tran->commit();
        } catch (\Exception $ex) {
            $tran->rollBack();
            \Yii::error('评价失败！'.$ex->getMessage(), '【rbac_shoot】');
            throw new BadRequestHttpException('评价失败!请联系管理员！<br/>'.$ex->getMessage());
        }
        
        return $this->redirect(['create','b_id'=>$b_id]);
    }

    /**
     * Updates an existing ShootAppraise model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $b_id
     * @param integer $u_id
     * @return mixed
     */
    public function actionUpdate($b_id, $u_id)
    {
        $model = $this->findModel($b_id, $u_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'b_id' => $model->b_id, 'u_id' => $model->u_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ShootAppraise model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $b_id
     * @param integer $u_id
     * @return mixed
     */
    public function actionDelete($b_id, $u_id)
    {
        $this->findModel($b_id, $u_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ShootAppraise model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $b_id
     * @param integer $u_id
     * @return ShootAppraise the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($b_id, $u_id)
    {
        if (($model = ShootAppraise::findOne(['b_id' => $b_id, 'u_id' => $u_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Finds the ShootBookdetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShootBookdetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findBookdetail($id)
    {
        $model = ShootBookdetail::findOne(['id'=>$id]);
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
