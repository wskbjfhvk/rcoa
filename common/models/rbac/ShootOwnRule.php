<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models\rbac;

/**
 * Description of ShootOwnUpdate
 *
 * @author Administrator
 */
class ShootOwnRule extends \yii\rbac\Rule {
    public $name = 'ShootOwnRule';
    //put your code here
    public function execute($user, $item, $params) {
        
        return isset($params['model']) ? $params['model']->u_booker == $user : false;
    }
}
