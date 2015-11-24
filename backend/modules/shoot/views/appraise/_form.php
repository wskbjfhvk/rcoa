<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\shoot\ShootAppraise */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shoot-appraise-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role_name')->dropDownList($roles, ['prompt'=>'请选择...']) ?>

    <?= $form->field($model, 'q_id')->dropDownList($questions, ['prompt'=>'请选择...']) ?>
    
    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'index')->textInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('rcoa', 'Create') : Yii::t('rcoa', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
