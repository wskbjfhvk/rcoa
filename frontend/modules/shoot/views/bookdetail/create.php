<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\shoot\ShootBookdetail */

$this->title = Yii::t('rcoa', 'Create Shoot Bookdetail');
?>
<div class="container shoot-bookdetail-create">

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'colleges' => $colleges,
        'projects' => $projects,
        'courses' => $courses,
    ]) ?>

</div>
