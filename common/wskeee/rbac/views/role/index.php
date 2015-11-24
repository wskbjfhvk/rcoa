<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\rbac\models\searchs\AuthItem */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = 'Role';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('创建角色', ['create'], ['class' => 'btn btn-success']) ?>
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 
    Pjax::end();
    ?>

</div>
