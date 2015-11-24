<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\shoot\components;
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use wskeee\rbac\RbacName;
use wskeee\rbac\RbacManager;

use common\models\shoot\ShootBookdetail;
/**
 * Description of ShootBookdetailActBtnCol
 *
 * @author Administrator
 */
class ShootBookdetailActBtnCol extends ShootBookdetailListTd 
{
    public $params = [];
    
    public function init() {
        parent::init();
        $this->format = 'html';
    }
    //put your code here
    public function getDataCellValue($model, $key, $index) 
    {
        $isMe = false;
        $buttonName = '';
        $url = '';
        $params = [];
        $btnClass = 'btn btn-block';
        /* @var $model ShootBookdetail */
        /* @var $authManager RbacManager*/
        $authManager = Yii::$app->authManager;
        $isNew = $model->getIsNew();
        $isAssign = $model->getIsAssign();
        //摄影组长
        if($authManager->isRole(RbacName::ROLE_SHOOT_LEADER, Yii::$app->user->id))
        {
            $buttonName = $isNew ? '未预约' : ($isAssign ? '指派' : $model->shootMan->nickname);
            $url = 'view';
            $params = [
                'id' => $model->id
            ];
            $btnClass .= ($isAssign ? ' btn-primary' : ' btn-default');
            $btnClass .= ($isNew ? ' disabled' : '');
            
        }else if($authManager->isRole(RbacName::ROLE_SHOOT_MAN, Yii::$app->user->id))
        {
            $buttonName = $isNew ? '未预约' :($isAssign ? '未指派' : $model->shootMan->nickname);
            $url = 'view';
            $params = [
                'id' => $model->id
            ];
            $btnClass .= ' btn-default';
            $btnClass .= ($isNew ? ' disabled' : '');
            $isMe = (!$isNew && $model->u_shoot_man && $model->shootMan->id == Yii::$app->user->id);
        }
        else if($authManager->isRole(RbacName::ROLE_WD, Yii::$app->user->id))
        {
            $buttonName = $isNew ? '预约' :$model->booker->nickname;
            $url = $isNew ? 'create' : 'view';
            $params = $isNew ? 
                    [
                        'site_id' => $model->site_id,
                        'book_time' => $model->book_time,
                        'index' => $model->index
                    ] : ['id' => $model->id];
            
            $btnClass .= ($isNew ? ' btn-primary' : ' btn-default');
            $isMe = !$isNew && $model->booker->id == Yii::$app->user->id;
        }
        $html = '';
        $html .= '<span class="rcoa-icon rcoa-icon-me is-me ' . ($isMe ? '' : 'hide') . '"/>';
        return $html . Html::a($buttonName, Url::to(
                                ArrayHelper::merge([$url], $params,$this->params)), 
                                ['class' => $btnClass, 'role' => "button"]) . '';
    }
}
