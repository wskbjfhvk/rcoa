<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model wskeee\framework\models\College */

$this->title = '创建学院';
$this->params['breadcrumbs'][] = ['label' => '学院', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="college-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
