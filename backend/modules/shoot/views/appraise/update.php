<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\shoot\ShootAppraise */

$this->title = Yii::t('rcoa', 'Update {modelClass}: ', [
    'modelClass' => 'Shoot Appraise',
]) . ' ' . $model->role_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rcoa', 'Shoot Appraises'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('rcoa', 'Update');
?>
<div class="shoot-appraise-update">

    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
        'questions' => $questions,
    ]) ?>

</div>
