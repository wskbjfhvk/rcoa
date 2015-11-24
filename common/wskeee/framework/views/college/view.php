<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model wskeee\framework\models\College */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '所有学院', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="college-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'des',
            ['attribute'=>'created_at','value'=>  date('Y/m/d H:i:s',$model->created_at)],
            ['attribute'=>'updated_at','value'=>  date('Y/m/d H:i:s',$model->updated_at)],
        ],
    ]) ?>
    
    <p>
        <?= Html::a('添加项目', 
                ['project/create','parent_id'=>$model->id], 
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
