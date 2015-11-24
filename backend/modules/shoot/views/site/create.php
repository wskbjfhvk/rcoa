<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\shoot\ShootSite */

$this->title = Yii::t('rcoa', 'Create Shoot Site');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rcoa', 'Shoot Sites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shoot-site-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
