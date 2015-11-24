<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\DetailView;

use wskeee\rbac\RbacAsset;

/* @var $this yii\web\View */
/* @var $model wskeee\rbac\AuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '所有权限', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:ntext',
            'ruleName',
            'data:ntext'
        ],
    ]) ?>
    
    <div class="row">
        <div class="col-lg-5">
            可分配：
            <input id="search-avaliable"><br />
            <select id="list-avaliable" multiple size="15" style="width: 100%">
            </select>
        </div>
        <div class="col-lg-1">
            <br><br>
            <a href="#" id="btn-add" class="btn btn-success" style="width: 100%">&gt;&gt;</a><br>
            <a href="#" id="btn-remove" class="btn btn-danger" style="width: 100%">&lt;&lt;</a>
        </div>
        <div class="col-lg-5">
            已分配：
            <input id="search-assigned"><br />
            <select id="list-assigned" multiple size="15" style="width: 100%">
            </select>
        </div>
    </div>
</div>
<?php
    RbacAsset::register($this);
    $properties = Json::htmlEncode([
        'id'=>$model->name,
        'assignUrl'=>  Url::to('assign'),
        'searchUrl'=>  Url::to('search')
    ]);
    $js = 
<<<JS
wskeee.rbac.initProperties($properties);

$('#search-avaliable').keydown(function(){
    wskeee.rbac.searchRole('avaliable');
});
$('#search-assigned').keydown(function(){
    wskeee.rbac.searchAssign('assigned');
});
$('#btn-add').click(function(){
    wskeee.rbac.addChild("assign");
    return false;
});
$('#btn-remove').click(function(){
    wskeee.rbac.addChild("remove");
    return false;
});
wskeee.rbac.searchRole('avaliable', true);
wskeee.rbac.searchAssign('assigned', true);
JS;
    $this->registerJs($js, yii\web\View::POS_READY);
?>
