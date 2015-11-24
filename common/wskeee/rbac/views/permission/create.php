<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\rbac\models\Permission */

$this->title = '创建权限';
$this->params['breadcrumbs'][] = ['label' => '所有权限', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'rules' => $rules
    ]) ?>

</div>
