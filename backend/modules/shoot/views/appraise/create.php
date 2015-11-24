<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\shoot\ShootAppraise */

$this->title = Yii::t('rcoa', 'Create Question');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rcoa', 'Shoot Appraises'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shoot-appraise-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'questions' => $questions,
        'roles' => $roles,
    ]) ?>

</div>
