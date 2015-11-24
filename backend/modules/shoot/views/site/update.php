<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\shoot\ShootSite */

$this->title = Yii::t('rcoa', 'Update {modelClass}: ', [
    'modelClass' => 'Shoot Site',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rcoa', 'Shoot Sites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('rcoa', 'Update');
?>
<div class="shoot-site-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
