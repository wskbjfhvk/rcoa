<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model wskeee\framework\models\Course */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '所有课程', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-view">

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

</div>
