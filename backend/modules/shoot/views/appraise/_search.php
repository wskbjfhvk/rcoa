<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\shoot\searchs\ShootAppraiseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shoot-appraise-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'role_name') ?>

    <?= $form->field($model, 'q_id') ?>

    <?= $form->field($model, 'index') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('rcoa', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('rcoa', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
