<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'RBAC',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        [
            'label' => '首页', 
            'items' => [
                 ['label' => '新闻事件', 'url' => '#']
            ]
        ]
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => '拍摄',
            'items' => [
                 ['label' => '评价题目', 'url' => '/shoot/appraise'],
                 ['label' => '场地管理', 'url' => '/shoot/site'],
            ]
        ];
        $menuItems[] = ['label' => '多媒体制作','url' => '#'];
        $menuItems[] = ['label' => '评优','url' => '#'];
        $menuItems[] = [
            'label' => '用户',
            'items' => [
                 ['label' => '用户', 'url' => '/user'],
                 ['label' => '角色', 'url' => '/rbac/role'],
                 ['label' => '权限', 'url' => '/rbac/permission'],
                 ['label' => '规则', 'url' => '/rbac/rule'],
            ]
        ];
        $menuItems[] = [
            'label' => '项目',
            'items' => [
                ['label' => '学院', 'url' => '/framework/college'],
                ['label' => '项目', 'url' => '/framework/project'],
                ['label' => '课程', 'url' => '/framework/course'],
            ]
        ];
        $menuItems[] = [
            'label' => '题库',
            'items' => [
                ['label' => '题目管理', 'url' => '/question'],
            ]
        ];

    $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
        
        $menuItems[] = '<li><img class=".img-responsive"  src="'.Yii::$app->user->identity->avatar.'" width="30" height="30"  ></li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
