<?php

namespace wskeee\rbac\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use yii\rbac\Item;
use wskeee\rbac\models\AuthItem;
use wskeee\rbac\models\searchs\AuthItemSearch;

/**
 * PremissionController implements the CRUD actions for Permission model.
 */
class PermissionController extends Controller
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
     * Lists all Permission models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch(['type'=> Item::TYPE_PERMISSION]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Permission model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Permission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItem(null,['type'=>  Item::TYPE_PERMISSION]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'rules' => $this->getRulesForSelect()
            ]);
        }
    }

    /**
     * Updates an existing Permission model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'rules' => $this->getRulesForSelect()
            ]);
        }
    }

    /**
     * Deletes an existing Permission model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Yii::$app->authManager->remove($model->item);
        return $this->redirect(['index']);
    }
    
     /**
     * 分配/删除 角色/权限 
     * @param string $id 用户id
     * @param  string $action 动作 assigne添加，其它删除
     */
    public function actionAssign()
    {
        $authManager = \Yii::$app->authManager;
        $post = \Yii::$app->getRequest()->post();
        $id = $post['id'];
        $action = $post['action'];
        $items = $post['items'];
        $parent = $authManager->getPermission($id);
        $error = [];
        
        foreach ($items as $item)
        {
            $child = $authManager->getPermission($item);
            try {
                if($action === 'assign')
                    $authManager->addChild($parent, $child);
                else
                    $authManager->removeChild ($parent, $child);
            } catch (\Exception $ex) {
                $error[] = $ex->getMessage();
            }
        }
        
        Yii::$app->getResponse()->format = 'json';
        
        return [
            'type'=>'S',
            'errors'=>$error
        ];
    }
    
    /**
     * 查找 角色/权限
     * @param string $id        角色id
     * @param string $target    avaliable所有/assigned已分配
     * @param string $term      过滤字符
     */
    public function actionSearch($id,$target,$term='')
    {
        $autoManager = Yii::$app->authManager;
        $result = [
            'Permissions'=>[]
        ];
        
        if($target === 'avaliable')
        {
            $children = array_keys($autoManager->getChildren($id));
            $children[] = $id;
            
            foreach ($autoManager->getPermissions() as $name=>$role)
            {
                if(in_array($name, $children))
                    continue;
                if(empty($term) || strpos($name, $term)!==false)
                    $result['Permissions'][$name] = $role;
            }
        }else
        {
            foreach($autoManager->getChildren($id) as $name => $child)
            {
                if(empty($term) || strpos($name,$term) !== false)
                    $result['Permissions'][$name] = $child;
            }
        }
        Yii::$app->getResponse()->format = 'json';
        return array_filter($result);
    }

    /**
     * Finds the Permission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Permission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $item = \Yii::$app->authManager->getPermission($id);
        if ($item !== null) {
            return new AuthItem($item);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function getRulesForSelect()
    {
        Yii::trace(ArrayHelper::map(Yii::$app->authManager->getRules(), 'name', 'name'));
        return ArrayHelper::map(Yii::$app->authManager->getRules(), 'name', 'name');
    }
}
