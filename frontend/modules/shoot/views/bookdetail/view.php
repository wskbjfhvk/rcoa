<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

use kartik\widgets\AlertBlock;
use kartik\widgets\Growl;

use wskeee\rbac\RbacName;

/* @var $this yii\web\View */
/* @var $model common\models\shoot\ShootBookdetail */

$this->title = $model->id;
?>

<div class="title">
    <div class="container">
        <?php echo '预约操作：【'.$model->site->name.'】'.
                date('Y/m/d ',$model->book_time).Yii::t('rcoa', 'Week '.date('D',$model->book_time)).' '.$model->getTimeIndexName() ?>
    </div>
</div>
<div class="container has-title shoot-bookdetail-view">
    
    <?= $this->render('_form_detail2', [
        'model' => $model,
        'shootmans' => $shootmans,
    ]) ?>
</div>
<div class="controlbar">
    <div class="container">
        <?php
            /**
             * 提交 按钮显示必须满足以下条件：
             * 1、拥有【指派】权限
             * 2、在拍摄任务完成前，即评价发生前
             */
            if(Yii::$app->user->can(RbacName::PERMSSIONT_SHOOT_ASSIGN) && $model->canAssign())
                echo Html::a('提交', 'javascript:;', ['id'=>'submit', 'class' => 'btn btn-danger']).' ';
            /**
             * 编辑 按钮显示必须满足以下条件：
             * 1、拥有【编辑】权限(管理员或者任务的发起者)
             * 2、在摄影师指派前
             */
            if($model->canEdit() && Yii::$app->user->can(RbacName::PERMSSIONT_SHOOT_UPDATE,['model'=>$model]))
                echo Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-danger']).' ';
            /**
             * 评价 按钮显示必须满足以下条件：
             * 1、拥有【评价】权限(编导和摄影师都有权限)
             * 2、在摄影师指派后，即摄影结束后
             * 3、查看【评价】权限为所有人
             */
            if($model->canAppraise())
                echo Html::a('评价', ['/shoot/appraise/create', 'b_id' => $model->id], ['class' => 'btn btn-danger']).' ';
        ?>
        
        <?= Html::a('返回', ['index','date'=>  date('Y-m-d',$model->book_time)], ['class' => 'btn btn-default']) ?>
    </div>
</div>
<?php
    $js = 
 <<<JS
    $('#submit').click(function()
            {
                $('#form-assign-shoot_man').submit();
            });
    
JS;
$this->registerJs($js,  View::POS_READY);
?>