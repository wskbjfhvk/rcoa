<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model wskeee\framework\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '所有项目', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="framework-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'des',
            [
                'attribute'=> 'parent.name',
                'label' => '所属学院,',                
            ],
            [
                'attribute' => 'created_at',
                'value' => date('Y/m/d H:i:s',$model->created_at)
            ],
            [
                'attribute' => 'updated_at',
                'value' => date('Y/m/d H:i:s',$model->updated_at)
            ]
        ],
    ]) ?>
    
    <p>
        <?= Html::a('添加课程', 
                ['course/create','parent_id'=>$model->id], 
                ['class' => 'btn btn-success', 'data' => ['method' => 'post']]) ?>
    </p>

    <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'des',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
