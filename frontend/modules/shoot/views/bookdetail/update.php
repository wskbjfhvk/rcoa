<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\shoot\ShootBookdetail */

$this->title = Yii::t('rcoa', 'Update {modelClass}: ', [
    'modelClass' => 'Shoot Bookdetail',
]) . ' ' . $model->id;
?>
<div class="shoot-bookdetail-update">
    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'colleges' => $colleges,
        'projects' => $projects,
        'courses' => $courses,
    ]) ?>

</div>
