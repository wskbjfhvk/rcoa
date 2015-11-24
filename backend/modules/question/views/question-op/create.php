<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\questions\QuestionOp */

$this->title = Yii::t('rcoa', 'Create Question Op');
?>
<div class="question-op-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
