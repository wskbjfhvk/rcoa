<?php

namespace wskeee\framework\controllers;

use yii\web\Controller;
use wskeee\framework\models\Item;
use wskeee\framework\FrameworkManager;

class ApiController extends Controller
{
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionList()
    {
        \Yii::$app->getResponse()->format = 'json';
        
        $errors = [];
        $items = [];
        try
        {
            $items = Item::find()->asArray()->all();
        } catch (\Exception $ex) {
            $errors [] = $ex->getMessage();
        }
        return [
            'type'=>'S',
            'data' => $items,
            'error' => $errors
        ];
    }
    
    /**
     * 获取项目子项
     * @param type $id
     * @return type JSON
     */
    public function actionSearch($id)
    {
        \Yii::$app->getResponse()->format = 'json';
        /* @var $fwManager FrameworkManager */
        $fwManager = \Yii::$app->get('fwManager');
        
        $errors = [];
        $items = [];
        try
        {
            $items = $fwManager->getChildren($id);
        } catch (\Exception $ex) {
            $errors [] = $ex->getMessage();
        }
        return [
            'type'=>'S',
            'data' => $items,
            'error' => $errors
        ];
    }
}
