<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\shoot\ShootBookdetail */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
    function field($label,$content)
    {
        $html = "<div class=\"form-group\">
                    <label class=\"col-xs-2 col-sm-2 col-md-1 col-lg-1 control-label\" style=\"color:#999999;font-weight:normal\">$label</label>
                    <div class=\"col-xs-4 col-sm-4 col-md-10 col-lg-10\">
                        <p class=\"form-control-static\">$content</p>
                    </div>
                  </div>";
        return $html;
    }
?>
<div class="shoot-bookdetail-form">

    <form class="form-horizontal">
        <h5><b>基本信息：</b></h5>
        <?= field($model->getAttributeLabel('status'), $model->getStatusName()) ?>
        <?= field($model->getAttributeLabel('u_contacter'), $model->contacter->nickname.'( '.$model->contacter->phone.' )') ?>
        <?= field($model->getAttributeLabel('u_booker'), $model->booker->nickname.'( '.$model->booker->phone.' )') ?>
        
        <h5><b>课程信息：</b></h5>
        <?= field($model->getAttributeLabel('fw_college'), $model->fwCollege->name) ?>
        <?= field($model->getAttributeLabel('fw_project'), $model->fwProject->name) ?>
        <?= field($model->getAttributeLabel('fw_course'), $model->fwCourse->name) ?>
        <?= field($model->getAttributeLabel('lession_time'), $model->lession_time) ?>
        
        <h5><b>老师信息：</b></h5>
        <?= field($model->getAttributeLabel('teacher_name'), $model->teacher_name.'( '.$model->teacher_phone.' )') ?>
        <?= field($model->getAttributeLabel('teacher_email'), $model->teacher_email) ?>
        
        <h5><b>拍摄信息：</b></h5>
        <?= field($model->getAttributeLabel('shoot_mode'), $model->getShootModeName()) ?>
        <?= field($model->getAttributeLabel('photograph'), $model->photograph ? '是' : '否') ?>
        <?= field($model->getAttributeLabel('u_shoot_man'), isset($model->u_shoot_man) ? $model->shootMan->nickname : "空")  ?>
        <?= Html::activeHiddenInput($model, 'ver') ?>
    </form>
</div>