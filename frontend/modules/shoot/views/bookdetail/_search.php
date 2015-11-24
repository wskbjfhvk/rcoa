<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\shoot\searchs\ShootBookdetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shoot-bookdetail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fw_college') ?>

    <?= $form->field($model, 'fw_project') ?>

    <?= $form->field($model, 'fw_course') ?>

    <?= $form->field($model, 'lession_time') ?>

    <?php // echo $form->field($model, 'teacher') ?>

    <?php // echo $form->field($model, 'contacter') ?>

    <?php // echo $form->field($model, 'booker') ?>

    <?php // echo $form->field($model, 'book_time') ?>

    <?php // echo $form->field($model, 'index') ?>

    <?php // echo $form->field($model, 'shoot_mode') ?>

    <?php // echo $form->field($model, 'photograph') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'ver') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('rcoa', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('rcoa', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
