<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace wskeee\framework\models;

/**
 * Description of College
 *
 * @author Administrator
 */
class College extends Item
{
    //put your code here
    public function save($runValidation = true, $attributeNames = null) 
    {
        $this->level = self::LEVEL_COLLEGE;
        
        return parent::save($runValidation, $attributeNames);
    }
}
