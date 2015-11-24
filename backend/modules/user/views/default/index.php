<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider;*/
/* @var $model common\models\User */

$this->title = '管理用户';

?>
<div class="user-index">
    <p>
        <?= Html::a('新增',['create'],['class'=>'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => yii\grid\CheckboxColumn::className()],
            'username',
            'nickname',
            'email',
            'ee',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('Y-m-d H:i:s', $model->created_at);
                }
            ],
            [
                'class' => yii\grid\ActionColumn::className(),
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/rbac/assignment/view','id'=>$key], $options);
                    }
                        ]
                    ]
                ],
                'tableOptions' => ['class' => 'table table-striped']
            ]);
            ?>
    
</div>
