<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model wskeee\framework\models\Course */

$this->title = '添加课程';
$this->params['breadcrumbs'][] = ['label' => '所有课程', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'parents' => $parents
    ]) ?>

</div>
