<?php

use common\models\shoot\ShootAppraise;
use common\models\shoot\ShootAppraiseResult;
use common\models\shoot\ShootBookdetail;
use wskeee\rbac\RbacManager;
use wskeee\rbac\RbacName;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $model ShootAppraise */

?>
<div class="title">
    <div class="container">
        <?php echo '评价操作：【'.$bookdetail->site->name.'】'.
                date('Y/m/d ',$bookdetail->book_time).Yii::t('rcoa', 'Week '.date('D',$bookdetail->book_time)).' '.$bookdetail->getTimeIndexName() ?>
    </div>
</div>
<div class="container shoot-appraise-create has-title">

    <?=
    $this->render('_form', [
        'bookdetail' => $bookdetail,
        'appraises' => $appraises,
        'results' => $results,
        'b_id' => $b_id,
    ])
    ?>

</div>
<div class="controlbar">
    <div class="container">
        <?php
            /*
             * 提交 按钮显示必须满足以下条件：
             * 1、拥有【评价】权限并且为任务的接洽人或者摄影师
             * 2、指派摄影师后
             */
        
             /* @var $bookdetail ShootBookdetail */
             /* @var $authManager RbacManager */
            $authManager = Yii::$app->authManager;
            
            Yii::trace(count(ShootAppraiseResult::findAll(['b_id'=>$bookdetail->id,'u_id'=>Yii::$app->user->id])));
            if(Yii::$app->user->can(RbacName::PERMSSIONT_SHOOT_OWN_APPRAISE,['job'=>$bookdetail])
                    && count(ShootAppraiseResult::findAll(['b_id'=>$bookdetail->id,'u_id'=>Yii::$app->user->id]))==0)
                echo Html::a('提交', 'javascript:;', ['id'=>'submit', 'class' => 'btn btn-danger']).' ';
        ?>
        
        <?= Html::a('返回',['bookdetail/view','id'=>$bookdetail->id] , ['class' => 'btn btn-default']) ?>
    </div>
</div>
<?php
    $js = 
 <<<JS
    $('#submit').click(function()
            {
                $('#shoot-appraise-form').submit();
            });
    
JS;
$this->registerJs($js,  View::POS_READY);
?>