<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace wskeee\project\models;

/**
 * Description of ProjectItem
 *
 * @author Administrator
 */
class ProjectItem extends \yii\base\Model {

    /** 学院 */
    const LEVEL_COLLEGE = 1;
    /** 项目 */
    const LEVEL_PROJECT = 2;
    /** 课程 */
    const LEVEL_COURSE = 3;
    
    //put your code here
    /** 项目id */
    public $id;
    /** 父级 */
    public $parentId = 0;
    /** 项目名 */
    public $name;
    /** 项目描述 */
    public $des;
    /** 项目等级 ProjectItem.LEVEL_COLLEGE / LEVEL_PROJECT / LEVEL_COURSE */
    public $level;
    
    /** 创建时间 */
    public $create_at;
    /** 更新时间 */
    public $update_at;
    
    

}
