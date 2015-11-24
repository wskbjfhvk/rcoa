<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\shoot\searchs\ShootSiteRuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rcoa', 'Shoot Site Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shoot-site-rule-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('rcoa', 'Create Shoot Site Rule'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'type',
            'site',
            'start_time:datetime',
            // 'end_time:datetime',
            // 'des',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
