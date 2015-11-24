<?php
namespace frontend\modules\shoot;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\web\AssetBundle;
/**
 * Description of RbacAsset
 *
 * @author Administrator
 */
class ShootAsset extends AssetBundle
{
    //public $basePath = '@webroot/assets';
    //public $baseUrl = '@web/assets';
    public $sourcePath = '@frontend/modules/shoot/assets';
    public $css = [
       'css/shoot.css'
    ];
    public $js = [
        
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
