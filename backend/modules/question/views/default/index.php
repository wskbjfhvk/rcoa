<?php

use yii\helpers\Html;
use yii\grid\GridView;

use common\models\question\Question;

/* @var $this yii\web\View */
/* @var $searchModel common\models\question\searchs\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rcoa', 'Questions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('rcoa', 'Create Question'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'type',
                'filter' => Question::$TYPES,
                'value' => function($model){
                    return $model->getTypeName();
                }
            ],
            'title',
            'des',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
