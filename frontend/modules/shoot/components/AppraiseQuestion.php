<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\shoot\components;

use common\models\question\Question;
use yii\base\Widget;
/**
 * Description of AppraiseQuestion
 *
 * @author Administrator
 */
class AppraiseQuestion extends Widget {
    
    /* @var $question Question 题目数据 */
    public $question;
    
    /** 选择答案 */
    public $value;
    
    public function run() 
    {
        
    }
}
