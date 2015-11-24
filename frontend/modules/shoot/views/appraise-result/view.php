<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\shoot\ShootAppraiseResult */

$this->title = $model->b_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rcoa', 'Shoot Appraise Results'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shoot-appraise-result-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('rcoa', 'Update'), ['update', 'b_id' => $model->b_id, 'u_id' => $model->u_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('rcoa', 'Delete'), ['delete', 'b_id' => $model->b_id, 'u_id' => $model->u_id], [
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
            'b_id',
            'u_id',
            'role_name',
            'value',
            'data',
        ],
    ]) ?>

</div>
