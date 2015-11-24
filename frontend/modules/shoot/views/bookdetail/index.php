<?php

use common\models\shoot\searchs\ShootBookdetailSearch;
use common\models\shoot\ShootBookdetail;
use frontend\modules\shoot\ShootAsset;
use kartik\widgets\DatePicker;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel ShootBookdetailSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('rcoa', 'Shoot Bookdetails');
?>
<div class="container shoot-bookdetail-index bookdetail-list">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'tableOptions' => ['class' => 'table table-striped'],
        'columns' => [
            [
                'class' => 'frontend\modules\shoot\components\ShootBookdetailListWeekTd',
                'value' => function($model) {
                    return date('Y/m/d ', $model->book_time) . Yii::t('rcoa', 'Week ' . date('D', $model->book_time));
                },
                'label' => '时间',
                'contentOptions' =>[
                    'rowspan' => 3, 
                    'style'=>[
                        'vertical-align' => 'middle',
                        'width' => '140px'
                    ]
                ] 
            ],
            [
                'class' => 'frontend\modules\shoot\components\ShootBookdetailListTd',
                'attribute' => 'timeIndexName',
                'label' => '',
                'contentOptions' =>[
                   'style'=>[
                        'vertical-align' => 'middle',
                        'width' => '30px',
                        'padding' => '4px',
                    ]
                ] 
            ],
            [
                'class' => 'frontend\modules\shoot\components\ShootBookdetailListTd',
                'attribute' => 'shoot_mode',
                'label' => '',
                'contentOptions' =>[
                   'style'=>[
                        'vertical-align' => 'middle',
                        'width' => '29px',
                        'padding' => '4px',
                    ]
                ], 
                'content' => function($model,$key,$index,$e)
                {
                    /* @var $model ShootBookdetail */
                    if($model->getIsNew())
                        return '';
                    return '<span class="rcoa-icon rcoa-icon-'.($model->shoot_mode == ShootBookdetail::SHOOT_MODE_SD ? 'sd' : 'hd').'"/>' ;
                }
            ],
            [
                'class' => 'frontend\modules\shoot\components\ShootBookdetailListTd',
                'attribute' => 'photograph',
                'label' => '',
                 'contentOptions' =>[
                    'style'=>[
                        'vertical-align' => 'middle',
                        'width' => '29px',
                        'padding' => '4px',
                    ]
                ], 
                'content' => function($model,$key,$index,$e)
                {
                    return $model->photograph == 1 ? '<span class="rcoa-icon rcoa-icon-camera"/>' : "";
                }
            ],
            [
                'class' => 'frontend\modules\shoot\components\ShootBookdetailListTd',
                'label' => '【课程名 x 课时】',
                 'contentOptions' =>[
                   
                ], 
                'content' => function($model,$key,$index,$e)
                {
                    /* @var $model ShootBookdetail */
                    if($model->getIsNew())
                        return '';
                    return '【'.$model->getFwCourse()->name.' x '.$model->lession_time.'】';
                }
            ],
            [
                'class' => 'frontend\modules\shoot\components\ShootBookdetailListTd',
                'label' => '【老 师 / 接洽人 / 预约人 / 摄影师】',
                 'contentOptions' =>[
                    'style'=> [
                        'width' => '300px',
                    ]
                ], 
                'content' => function($model,$key,$index,$e)
                {
                    /* @var $model ShootBookdetail */
                    if($model->getIsNew())
                        return '';
                    $good = '<span class="rcoa-icon rcoa-icon-crying"></span>';
                    $good = $model->getAppraiseInfo();
                    /* @var $model ShootBookdetail */
                    $teacherName = isset($model->u_teacher) ? $model->teacher->nickname : '空';
                    $contacterName = isset($model->u_contacter) ? $model->contacter->nickname : '空';
                    $bookerName = isset($model->u_booker) ? $model->booker->nickname : '空';
                    $shootManName = isset($model->u_shoot_man) ? $model->shootMan->nickname : '空';
                    return '【'.$teacherName.' / '.$contacterName.' / '.$good.$bookerName.' / '.$shootManName.'】';
                }
            ],
            [
                'class' => 'frontend\modules\shoot\components\ShootBookdetailListTd',
                'label' => '【状态】',
                'contentOptions' =>[
                    'style'=> [
                        'width' => '90px',
                    ]
                ], 
                'content' => function($model,$key,$index,$e)
                {
                    /* @var $model ShootBookdetail */
                    if($model->getIsNew())
                        return '';
                    /* @var $model ShootBookdetail */
                    return '【'.$model->getStatusName().'】';
                }
            ],
            [
                'class' => 'frontend\modules\shoot\components\ShootBookdetailActBtnCol',
                'label' => '操作',
                'contentOptions' =>[
                    'style'=> [
                        'width' => '90px',
                        'padding' =>'4px',
                    ]
                ],
            ],
        ],
    ]);
    ?>
</div>

<div class="controlbar">
    <div class="container">
        <div class="row ">
            <div class="btn btn-default" style="padding: 0px">
                <?= Html::dropDownList('site', 0, ['6-5摄']) ?>
            </div>
            <div  class="btn btn-default" style="padding: 0px;width: 85px">
                <?=
                DatePicker::widget([
                    'name' => 'check_issue_date',
                    'type' => DatePicker::TYPE_INPUT,
                    'value' => date('Y/m'),
                    'options' => ['placeholder' => 'Select issue date ...'],
                    'pluginOptions' => [
                        'format' => 'yyyy/m',
                        'todayHighlight' => true,
                        'minViewMode' => 1,
                    ]
                ]);
                ?>
            </div>
            <?= 
                Html::a('<label class="glyphicon glyphicon-chevron-left"/>', 
                        Url::to(['/shoot/bookdetail','date'=>$prevWeek]),['class'=>'btn btn-default']);
            ?>
             <?= 
                Html::a('<label class="glyphicon glyphicon-chevron-right"/>', 
                        Url::to(['/shoot/bookdetail','date'=>$nextWeek]),['class'=>'btn btn-default']);
            ?>
        </div>
    </div>
</div>
<?php
    ShootAsset::register($this);
?>