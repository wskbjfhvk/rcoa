<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\shoot\ShootSite */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rcoa', 'Shoot Sites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shoot-site-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'traffic',
            'des',
        ],
    ]) ?>
    
    <?php
    /*
    <h1>应用规则</h1>
    <h4>选择时间：</h4>
    echo DatePicker::widget([
        'name' => 'dp_3',
        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
        'value' => date('Y/m',time()),
        'readonly' => true,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy/mm',
            'minViewMode' => 1
        ],
        'pluginEvents' => [
            "show" => "function(e) {   }",
            "hide" => "function(e) {   }",
            "clearDate" => "function(e) {   }",
            "changeDate" => "function(e) {   }",
            "changeYear" => "function(e) {   }",
            "changeMonth" => "function(e) {   }",
        ]
    ]);*/
    ?>
</div>
