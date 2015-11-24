<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\shoot\models\ShootBookdetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shoot-bookdetail-form">

    <?php $form = ActiveForm::begin([
        'options'=>['class'=>'form-horizontal'],
        'fieldConfig' => [  
            'template' => "{label}：\n<div class=\"col-lg-10 col-md-10\">{input}</div>\n<div class=\"col-lg-10 col-md-10\">{error}</div>",  
            'labelOptions' => ['class' => 'col-lg-1 col-md-1 control-label','style'=>['color'=>'#999999','font-weight'=>'normal']],  
        ], 
        ]); ?>
    
    <h5><b>课程信息：</b></h5>
    <?= $form->field($model, 'fw_college')->dropDownList($colleges,['prompt'=>'请选择...','onchange'=>'wx_one(this)',]) ?>

    <?= $form->field($model, 'fw_project')->dropDownList($projects,['prompt'=>'请选择...','onchange'=>'wx_two(this)',]) ?>

    <?= $form->field($model, 'fw_course')->dropDownList($courses,['prompt'=>'请选择...']) ?>

    <?= $form->field($model, 'lession_time')->textInput() ?>

    <h5><b>老师信息：</b></h5>
    <?= $form->field($model, 'teacher_name')->textInput() ?>
    
    <?= $form->field($model, 'teacher_phone')->textInput() ?>
    
    <?= $form->field($model, 'teacher_email')->textInput() ?>

    <h5><b>其它信息：</b></h5>
    <?= $form->field($model, 'u_contacter')->dropDownList($users,['prompt'=>'请选择...']) ?>

    <?= $form->field($model, 'u_booker')->dropDownList($users,['prompt'=>'请选择...']) ?>

    <?= $form->field($model, 'shoot_mode')->radioList([1=>'高清',2=>'标清'],[
        'separator'=>'',
        'itemOptions'=>[
            'labelOptions'=>[
                'style'=>[
                     'margin-right'=>'50px'
                ]
               ]]]) ?>

    <?= $form->field($model, 'photograph')->checkbox()->label('') ?>
    
    <?= Html::activeHiddenInput($model, 'ver') ?>
    <?= Html::activeHiddenInput($model, 'site_id') ?>
    <?= Html::activeHiddenInput($model, 'book_time') ?>
    <?= Html::activeHiddenInput($model, 'index') ?>
    <?= Html::activeHiddenInput($model, 'status') ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('rcoa', 'Create') : Yii::t('rcoa', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">

    function wx_one(e){
        console.log($(e).val());
	$("#shootbookdetail-fw_course").html("");
	$("#shootbookdetail-fw_project").html("");
	$.post("/framework/api/search?id="+$(e).val(),function(data)
        {
            $('<option/>').appendTo($("#shootbookdetail-fw_project"));
            $.each(data['data'],function()
            {
                $('<option>').val(this['id']).text(this['name']).appendTo($("#shootbookdetail-fw_project"));
            });
	});
    }
    function wx_two(e){
        $("#shootbookdetail-fw_course").html("");
        $.post("/framework/api/search?id="+$(e).val(),function(data)
        {
            $('<option/>').appendTo($("#shootbookdetail-fw_course"));
            $.each(data['data'],function()
            {
                $('<option>').val(this['id']).text(this['name']).appendTo($("#shootbookdetail-fw_course"));
            });
        });
    }
</script>