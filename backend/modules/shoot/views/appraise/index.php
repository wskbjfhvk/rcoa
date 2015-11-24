<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\shoot\searchs\ShootAppraiseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rcoa', 'Shoot Appraises');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shoot-appraise-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('rcoa', 'Create Question'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'role_name',
                'value' => function($model){
                    /* @var $model common\models\shoot\ShootAppraise */
                    return $model->getRole()->description;
                },
                'options' => [
                    'class'=>'col-sm-2'
                ]
            ],
            [
                'label' => '题目',
                'value' => function($model){
                    /* @var $model common\models\shoot\ShootAppraise */
                    return $model->question->title;
                },
            ],
            'value',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
            ],
    ],
    ]); ?>

</div>
