<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\question\Question */

$this->title = Yii::t('rcoa', 'Update {modelClass}: ', [
    'modelClass' => 'Question',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rcoa', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('rcoa', 'Update');
?>
<div class="question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
