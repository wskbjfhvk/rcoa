<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\question\Question */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rcoa', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'type',
                'value' => $model -> getTypeName(),
            ],
            'title',
            'des',
        ],
    ]) ?>

</div>
<?=
    Html::a('添加选项', ['/question/question-op/create', 'q_id' => $model->id], [
        'class' => 'btn btn-success',
        'data' => [
            'method' => 'post',
        ]
    ])
    ?>
    
    <?=
    GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $model->getOps()->orderBy(['value' => SORT_DESC])->all(),
                ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => '标题',
                'value' => function ($model, $key, $index, $column) {
                    /* @var $model QuestionOp */
                    return "$model->value 分($model->title)";
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/question/question-op/update', 'id' => $model->id]);
                    },
                    'delete' => function($url, $model, $key) {
                        /* @var $model ShootGradeOp */
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/question/question-op/delete', 'id' => $model->id], [
                                    'data' => [
                                        'method' => 'post'
                                    ]
                                        ]
                        );
                    }
                    ]
                ],
            ],
    ]);
    ?>
</div>