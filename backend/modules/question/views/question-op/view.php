<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\questions\QuestionOp */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rcoa', 'Question Ops'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-op-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('rcoa', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('rcoa', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('rcoa', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'question_id',
            'type',
            'title',
            'value',
        ],
    ]) ?>

</div>
