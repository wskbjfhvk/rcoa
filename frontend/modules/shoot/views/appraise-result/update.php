<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\shoot\ShootAppraiseResult */

$this->title = Yii::t('rcoa', 'Update {modelClass}: ', [
    'modelClass' => 'Shoot Appraise Result',
]) . ' ' . $model->b_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rcoa', 'Shoot Appraise Results'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->b_id, 'url' => ['view', 'b_id' => $model->b_id, 'u_id' => $model->u_id]];
$this->params['breadcrumbs'][] = Yii::t('rcoa', 'Update');
?>
<div class="shoot-appraise-result-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
