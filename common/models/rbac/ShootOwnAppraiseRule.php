<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models\rbac;

use common\models\shoot\ShootBookdetail;
use yii\rbac\Rule;

/**
 * Description of ShootOwnAppraiseRule
 *
 * @author Administrator
 */
class ShootOwnAppraiseRule extends Rule {
    
    public $name = 'ShootOwnAppraiseRule';
    //put your code here
    public function execute($user, $item, $params) {
        /* @var $job ShootBookdetail */
        $job = isset($params['job']) ? $params['job'] : null;
        
        return $job == null ? false : ($job->u_contacter == $user || $job->u_shoot_man == $user);
    }
}
