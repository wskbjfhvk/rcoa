<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel wskeee\rbac\search\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '所有权限';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('创建权限', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php 
    Pjax::begin(['enablePushState'=>false]); 
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'description:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]);
    Pjax::end();
    ?>
    
</div>
