<?php

namespace wskeee\framework;
/**
 * @property wskeee\framework\ProjectManager $frameworkManager 项目数据管理
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'wskeee\framework\controllers';
    
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
    
    
    
    public function getProjectManager()
    {
        return $this->get('frameworkManager', false);
    }
}
