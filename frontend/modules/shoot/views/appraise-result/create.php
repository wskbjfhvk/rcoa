<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\shoot\ShootAppraiseResult */

$this->title = Yii::t('rcoa', 'Create Shoot Appraise Result');
?>
<div class="title">
    <div class="container">
        <?php
            $bookdetail = $model->bookdetail;
            echo '评价操作：【'.$bookdetail->site->name.'】'.
                date('Y/m/d ',$bookdetail->book_time).Yii::t('rcoa', 'Week '.date('D',$bookdetail->book_time)).' '.$bookdetail->getTimeIndexName() 
        ?>
    </div>
</div>
<div class="shoot-appraise-result-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
