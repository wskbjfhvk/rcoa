<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models\rbac;
use yii\rbac\Rule;
/**
 * Description of MyRule
 *
 * @author Administrator
 */
class MyRule extends Rule{
    
    public $name = 'myRule';
    //put your code here
    public function execute($user, $item, $params) 
    {
        return true;
    }
}
