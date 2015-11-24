<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\question\Question */

$this->title = Yii::t('rcoa', 'Create Question');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rcoa', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
