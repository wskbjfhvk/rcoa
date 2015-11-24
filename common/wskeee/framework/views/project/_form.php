<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model wskeee\framework\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="framework-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'parent_id')->dropDownList($parents,['prompt'=>'Select...'])->label('所属学院') ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'des')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
