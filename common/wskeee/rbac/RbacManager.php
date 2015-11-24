<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace wskeee\rbac;

use yii\rbac\DbManager;
use yii\rbac\Item;
use yii\db\Query;
use yii\caching\Cache;
use yii\helpers\ArrayHelper;

use common\models\User;
/**
 * Description of RbacManager
 *
 * @author Administrator
 */
class RbacManager extends DbManager{
    
    public function init() 
    {
        parent::init();
        $this->invalidateCache();
        $this->loadFromCache();
    }
    /*
     * 角色所包括的用户
     * @var type role => [user,user]
     */
    protected $itemToUsers;

    /**
     *
     * @var array [parent => list of child]
     */
    protected $childs;
    
    /**
     * 
     * @var array [item_name => user]
     */
    protected $assignmentToUsers;

    public function loadFromCache()
    {
        if ($this->items !== null || !$this->cache instanceof Cache) {
            return;
        }

        $data = $this->cache->get($this->cacheKey);
        
        if (is_array($data) && isset($data[0], $data[1], $data[2], $data[3])) {
            list ($this->items, $this->rules, $this->parents,$this->itemToUsers) = $data;
            return;
        }

        $query = (new Query)->from($this->itemTable);
        $this->items = [];
        foreach ($query->all($this->db) as $row) {
            $this->items[$row['name']] = $this->populateItem($row);
        }

        $query = (new Query)->from($this->ruleTable);
        $this->rules = [];
        foreach ($query->all($this->db) as $row) {
            $this->rules[$row['name']] = unserialize($row['data']);
        }

        
        $query = (new Query)->from($this->itemChildTable);
        $this->parents = [];
        foreach ($query->all($this->db) as $row) {
            if (isset($this->items[$row['child']])) {
                $this->parents[$row['child']][] = $row['parent'];
            }
            /*
            if (isset($this->items[$row['parent']])) {
                $this->childs[$row['parent']][] = $row['child'];
            }*/
        }
        
        //create roleToUsers;
        $this->itemToUsers = [];
        $this->assignmentToUsers = [];
         
        $query = (new Query)->from($this->assignmentTable);
        foreach ($query->all($this->db) as $row)
        {
            if(isset($this->items[$row['item_name']]))
                $this->assignmentToUsers[$row['item_name']][] = $row['user_id'];
        }
        $result;
        foreach ($this->items as $itemName => $item)
        {
            $result = [];
            $this->getItemUser($itemName, $result);
            $this->itemToUsers[$itemName] = array_unique($result);
        }
        
        $this->cache->set($this->cacheKey, [$this->items, $this->rules, $this->parents,$this->itemToUsers]);
    }
    
    /**
     * 获取属于该角色或者权限的所有用户
     * @param string $itemName  目标角色或者权限
     * @param array $result     最终结果,所甩用户集合
     */
    protected function getItemUser($itemName,&$result)
    {
        if(isset($this->assignmentToUsers[$itemName]))
        {
            $result = ArrayHelper::merge($this->assignmentToUsers[$itemName],$result);
            if(isset($this->parents[$itemName]))
            {
                foreach ($this->parents[$itemName] as $child)
                    $this->getItemUser($child,$result);
            }
        }
    }
    
    /**
     * 获取拥有该角色或者权限所有用户，<br/>
     * 比如，获取所有【编导】，或者所有能【创建预约】的用户
     * @param string $itemName  角色或者权限 [User]
     */
    public function getItemUsers($itemName)
    {
        $result = [];
        if(isset($this->itemToUsers[$itemName]))
            $result = User::findAll(['id'=>  $this->itemToUsers[$itemName]]);
        return $result;
    }
    
    /**
     * 判断用户是否属于{$roseName} 角色
     * @param type $roleName    目标角色
     * @param type $userId      目标id
     * @return boolean 
     */
    public function isRole($roleName,$userId)
    {
        /* @var $user User */
        if(isset($this->itemToUsers[$roleName]))
        {
            foreach($this->itemToUsers[$roleName] as $uid)
            {
                if($uid == $userId)
                    return true;
            }
        }
        return false;
    }
}
