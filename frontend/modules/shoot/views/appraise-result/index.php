<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\shoot\searchs\ShootAppraiseResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rcoa', 'Shoot Appraise Results');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shoot-appraise-result-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('rcoa', 'Create Shoot Appraise Result'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'b_id',
            'u_id',
            'role_name',
            'value',
            'data',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
