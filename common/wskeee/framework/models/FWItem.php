<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace wskeee\framework\models;

/**
 * Description of FWItem
 *
 * @author Administrator
 */
class FWItem extends \yii\base\Component 
{
    /** 学院 */
    const LEVEL_COLLEGE = 1;
    /** 项目 */
    const LEVEL_PROJECT = 2;
    /** 课程 */
    const LEVEL_COURSE = 3;
    
    /* @var $id 项目数据id */
    public $id;
    
    /* @var $name 项目名称 */
    public $name;
    
    /* @var $level 项目等级 */
    public $level;
    
    /* @var $parent_id 项目父级 */
    public $parent_id;
    
    /* @var $des 项目描述 */
    public $des;
    
    /* @var $created_at 创建时间 */
    public $created_at;
    
    /* @var $updated_at 更新时间 */
    public $updated_at;
}
