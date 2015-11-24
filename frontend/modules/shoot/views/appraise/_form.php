<?php

use common\models\question\QuestionOp;
use common\models\shoot\ShootAppraise;
use common\models\shoot\ShootAppraiseResult;
use common\models\shoot\ShootBookdetail;
use frontend\modules\shoot\ShootAsset;
use wskeee\rbac\RbacManager;
use wskeee\rbac\RbacName;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model ShootAppraise */
/* @var $form ActiveForm */
?>

<div class="shoot-appraise-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'shoot-appraise-form',
                'action' => '/shoot/appraise/add',
                'options' =>
                [
                    'class' => 'appraise-form',
                ]
    ]);
    ?>

    <?php 
        if(count($appraises) == 0)
        {
            echo "<h2>未找评价题目！</h2>";
        }else
        {
            /* @var $appraise ShootAppraise */
            /* @var $bookdetail ShootBookdetail */
            /* @var $authManager RbacManager */
            
            $authManager = Yii::$app->authManager;
            $user = Yii::$app->user;
            
            $results = ArrayHelper::index($results, function($result){
                /* @var $result ShootAppraiseResult */
                return $result->role_name.'-'.$result->q_id;
            });
            
            foreach($appraises as $role_name => $appraise_arr)
            {
                $disabled = !(
                        ($bookdetail->u_contacter == $user->id && $role_name != RbacName::ROLE_CONTACT) || 
                        ($bookdetail->u_shoot_man == $user->id && $role_name != RbacName::ROLE_SHOOT_MAN));
                /* 显示答题情况 */
                $value_result = getResult($appraise_arr, $results);
                $has_do = isset($results[getQName($appraise_arr[0])]);
                $icon = $has_do ? getIcon($value_result['sum'], $value_result['all']) : '';
                echo '<h4>'.Html::label($appraise_arr[0]->role->description.$icon).'</h4>';
                foreach($appraise_arr as $index => $appraise)
                {
                    $items = ArrayHelper::map($appraise->question->ops, 'value', function($op){
                        /* @var $op QuestionOp */
                        return $op->value."分 ( $op->title )";
                    });
                    echo Html::label(($index+1).'、'.$appraise->question->title);
                    echo Html::radioList(
                            "$appraise->role_name-$appraise->q_id", 
                            isset($results[getQName($appraise)]) ? $results[getQName($appraise)]->value : null, 
                            $items,
                            [
                                'class'=>'form-group',
                                'itemOptions' => [
                                    'labelOptions'=>[
                                        'class' =>'radio-group',
                                    ],
                                    'disabled' => ($disabled || $has_do),
                                ],
                                
                            ]);
                }
                
            }
        }
        
        /**
         * 获取答题 得分和总分
         * @param array $appraise_arr   答题数据
         * @param array $resultes       答题记录
         * @return array(sum,all)
         */
        function getResult($appraise_arr,$results)
        {
            /* @var $appraise ShootAppraise */
            $value_sum = 0;
            $value_all = 0;
            
            foreach ($appraise_arr as $index => $appraise)
            {
                $value_sum += (isset($results[getQName($appraise)]) ? $results[getQName($appraise)]->value : 0);
                $value_all += $appraise->value;
            }
            return ['sum'=>$value_sum,'all'=>$value_all];
        }
        
        /**
         * 获取题目结果合并名
         * @param ShootAppraise $appraise
         * @return string role_name-q_id
         */
        function getQName($appraise)
        {
            return "$appraise->role_name-$appraise->q_id";
        }
        
        /**
         * 
         * @param int $value_sum    得到总分
         * @param int $value_all   题目总分
         */
        function getIcon($value_sum,$value_all)
        {
            $icon = '';
            if ($value_sum == $value_all)
                $icon.='happy';
            else if ($value_sum >= $value_all / 2)
                $icon.='disappointed';
            else
                $icon.='crying';
            $icon = '<span class="rcoa-icon rcoa-icon-' .$icon . '"/>';
            
            return $icon;
        }
    ?>
    
    <?= Html::hiddenInput('b_id', $b_id) ?>
    
    <?php ActiveForm::end(); ?>

</div>
<?php ShootAsset::register($this) ?>
