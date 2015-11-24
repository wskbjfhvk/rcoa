<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models\shoot;

use Exception;
use Yii;
use yii\base\Model;
use yii\db\Query;
/**
 * Description of ShootAppraiseWork
 * @property int $b_id 任务id
 * @author Administrator
 */
class ShootAppraiseWork extends Model {
    
    const TABLE_NAME = '{{%shoot_appraise}}';
    
    public $b_id;
    
    /**
     * 复制作题目模板作为当前任务评价题目
     * @param array $row        ['role_name','q_id']
     */
    public function save($row)
    {
        try
        {
            $values = [];
            foreach ($row as $item)
            {
                $item = array_values($item);
                array_unshift($item, $this->b_id);
                $values [] = $item; 
            }
            Yii::$app->db->createCommand()->delete(self::TABLE_NAME, ['b_id'=>$this->b_id])->execute();
            Yii::$app->db->createCommand()->batchInsert(
                    self::TABLE_NAME, ['b_id', 'role_name', 'q_id', 'value' ,'index'], $values)->execute();
            return true;
        }catch(Exception $ex)
        {
            Yii::error('添加评价题目失败！'.$ex->getMessage());
            throw $ex;
            return false;
        }
    }
    
    /**
     * 查询所有评价题目
     * @return array('role_name'=>[])
     */
    public function find()
    {
        $models = ShootAppraise::find()
                ->where(['b_id'=>$this->b_id])
                ->with('question')
                ->with('question.ops')
                ->all();
        $result =[];
        /* @var $model ShootAppraise */
        foreach($models as $model)
            $result[$model->role_name] [] = $model;
        return $result;
    }
}
