<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models\rbac;

/**
 * Description of ShootOwnCancel
 *
 * @author Administrator
 */
class ShootOwnCancelRule extends ShootOwnRule 
{
    public $name = 'ShootOwnCancelRule';
    //put your code here
    public function execute($user, $item, $params)
    {
        $isOwn = parent::execute($user, $item, $params);
        return $isOwn && (isset($params['job']) ? $params['job']->booktime - time()>=24*60*60*1000 : false);
    }
}
