<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

use wskeee\rbac\RbacManager;
use wskeee\rbac\RbacName;

use frontend\modules\shoot\ShootAsset;

/* @var $this yii\web\View */
/* @var $model common\models\shoot\ShootBookdetail */

?>
<div class="auth-item-view">
    <?php $form = ActiveForm::begin(['id' => 'form-assign-shoot_man', 'action'=>'assign?id='.$model->id]); ?>
    <?php
    /* @var $authManager RbacManager */
    $authManager = Yii::$app->authManager;
    $isShootManLeader = $authManager->isRole(RbacName::ROLE_SHOOT_LEADER, Yii::$app->user->id);
    
    echo DetailView::widget([
        'model' => $model,
        'template' => '<tr><th class="viewdetail-th">{label}</th><td class="viewdetail-td">{value}</td></tr>',
        'attributes' => [
            ['label' => '<span class="btn-block viewdetail-th-head">基本信息</span>','value'=>''],
            [
                'attribute' => 'status',
                'value' => $model->getStatusName(),
            ],
            [
                'attribute' => 'u_contacter',
                'value' => $model->contacter->nickname. '( '.$model->contacter->phone.' )',
            ],
            [
                'attribute' => 'u_booker',
                'value' => $model->booker->nickname. '( '.$model->booker->phone.' )',
            ],
            
            
            ['label' => '<span class="btn-block viewdetail-th-head">课程信息</span>','value'=>''],
            [
                'attribute' => 'fw_college',
                'value' => $model->fwCollege->name,
            ],
            [
                'attribute' => 'fw_project',
                'value' => $model->fwProject->name,
            ],
            [
                'attribute' => 'fw_course',
                'value' => $model->fwCourse->name,
            ],
            [
                'attribute' => 'lession_time',
                'value' => $model->lession_time,
            ],
            
            
            ['label' => '<span class="btn-block viewdetail-th-head">老师信息</span>','value'=>''],
            [
                'attribute' => 'teacher_name',
                'value' => "$model->teacher_name( $model->teacher_phone )",
            ],
            [
                'attribute' => 'teacher_email',
                'value' => $model->teacher_email,
            ],
            
            
            ['label' => '<span class="btn-block viewdetail-th-head">拍摄信息</span>','value'=>''],
            [
                'attribute' => 'shoot_mode',
                'value' => $model->getShootModeName(),
            ],
            [
                'attribute' => 'photograph',
                'value' => $model->photograph ? '是' : '否',
            ],
            [
                'attribute' => 'u_shoot_man', 
                'format' => 'raw',
                'value' => $isShootManLeader ?
                         Html::activeDropDownList($model, 'u_shoot_man', $shootmans,['prompt'=>'选择摄影师...']) : (isset($model->u_shoot_man) ? $model->shootMan->nickname : "空"),
            ],
        ],
    ]);
    ?>
    <?php ActiveForm::end(); ?>
</div>
<?php
    ShootAsset::register($this);
?>