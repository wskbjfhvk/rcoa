<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

use common\models\User;
use common\models\searchs\UserSearch;

class DefaultController extends Controller
{
   public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(\Yii::$app->getRequest()->getQueryParams());
        return $this->render('index',[
            'dataProvider'=>$dataProvider,
            'searchModel'=>$searchModel
        ]);
    }
    
    public function actionCreate()
    {
        if(!Yii::$app->user->can('shoot_index'))
        {
            //throw new \yii\web\ForbiddenHttpException('无权访问!'.Yii::$app->user->id);
        }
        $model = new User();
        $model->scenario = User::SCENARIO_CREATE;
        
        if(Yii::$app->request->isPost)
        {
            if($model->load(\Yii::$app->request->post()) && $model->save())
            {
                return $this->redirect ('index');
            }
                
        }
        return $this->render('create',['model'=>$model]);
    }
    
    public function actionDelete($id)
    {
        /*@var $model common\models\User*/
        
        if(($model = $this->findModel($id)) !== null)
        {
            if($id !== Yii::$app->getUser()->getId())
            {
                $model->delete();
                return $this->redirect(['index']);
            }else
                throw new \yii\base\Exception('自己不可以删除自己');
        }
        else
            throw new \yii\base\Exception('找不到对应用户！');
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = User::SCENARIO_UPDATE;
        
        if($model->load(Yii::$app->getRequest()->post()) && $model->save())
        {
            return $this->redirect(['index']);
        }else
        {
            $model->password = '';
            return $this->render('update',['model'=>$model]);
        }
    }
    
    /**
     * 查找用户模型
     * @param integer $id   用户模型id
     * @return common\models\User 用户模型
     * @throws \yii\web\NotFoundHttpException
     */
    private function findModel($id)
    {
        if(($model = User::findOne(['id'=>$id])) !== null)
            return $model;
        else
            throw new \yii\web\NotFoundHttpException();
    }
}
