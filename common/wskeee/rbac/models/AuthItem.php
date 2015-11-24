<?php

namespace wskeee\rbac\models;

use Yii;
use yii\rbac\Item;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

/**
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * 
 * @property yii\rbac\Item $item 数据
 */
class AuthItem extends \yii\base\Model
{
    public $name;
    public $type;
    public $description;
    public $ruleName;
    public $data;

    /**
     * @var yii\rbac\Item
     */
    private $_item;
    
    /**
     *
     * @var yii\rbac\ManagerInterface
     */
    protected $authManager;


    /**
     * 初始对象
     * @param Item $item
     * @param array $config
     */
    public function __construct($item,$config = array()) 
    {
        $this->authManager = Yii::$app->authManager;
        $this->_item = $item;
        if($item !== null)
        {
            $this->name = $item->name;
            $this->type = $item->type;
            $this->description = $item->description;
            $this->ruleName = $item->ruleName;
            $this->data = $item->data === null ? null : json_decode($time->data);
        }
        parent::__construct($config);
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'eblog_auth_item';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['name'],'unique','when'=>function()
                {
                    return $this->getIsNewRecord() || ($this->_item->name != $this->name);
                }],
            [['name'], 'match', 'pattern' => '/^[\w-]+$/'],
            [['type'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'ruleName'], 'string', 'max' => 64],
            [['ruleName'],'in',
                'range'=>  array_keys($this->authManager->getRules()),
                'message'=>'没有找到对应规则!'],
            [['description', 'data', 'ruleName'], 'default']
        ];
    }
    
    /**
     * 重写唯一过虑器
     */
    public function unique()
    {
        $value = $this->name;
        if($this->authManager->getRole($value) !== null || $this->authManager->getPermission($value) !== null)
        {
            $message = \Yii::t('yii', '{attribute}"{value}" has already been taken.');
            $params = [
                'attribute'=>$this->getAttributeLabel('name'),
                'value'=>$value
            ];
            $this->addError('name', \Yii::$app->getI18n()->format($message, $params, \Yii::$app->language));
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '名称',
            'type' => '类型',
            'description' => '描述',
            'ruleName' => '规则名',
            'data' => 'Data',
            'created_at' => '创建于',
            'updated_at' => '更新于',
        ];
    }
    
    /**
     * 检查是否为新创建对象
     * @return boolean
     */
    public function getIsNewRecord()
    {
        return $this->_item === null;
    }
    
    /**
     * 查找角色
     * @param string $id
     * @return null|\self
     */
    public static function find($id)
    {
        $item = Yii::$app->authManager->getRole($id);
        if($item !== null)
            return new self($item);
        return null;
    }
    
    /**
     * 获取类型名
     * @param mixed $type
     * @return string|array;
     */
    public static function getTypeName($type = null)
    {
        $result = [
            Item::TYPE_ROLE => 'Role',
            Item::TYPE_PERMISSION => 'Permission'
        ];
        if($type !== null)
            return $result[$type];
        return $result;
    }

    /**
     * 保存 角色/权限到 [yii\rbac\authManager]
     */
    public function save()
    {
        if($this->validate())
        {
            if($this->_item === null)
            {
                if($this->type == Item::TYPE_ROLE)
                    $this->_item = $this->authManager->createRole($this->name);
                else
                    $this->_item = $this->authManager->createPermission ($this->name);
                $isNew = true;
            }else
            {
                $isNew = false;
                $oldName = $this->_item->name;
            }
            $this->_item->name = $this->name;
            $this->_item->description = $this->description;
            $this->_item->ruleName = $this->ruleName;
            $this->_item->data = $this->data === null || $this->data === '' ? null : json_decode($this->data);
            
            if($isNew)
                $this->authManager->add ($this->_item);
            else
                $this->authManager->update ($oldName, $this->_item);
            return true;
        }else
            return false;
    }
    
    /**
     * 
     * @return yii\rbac\Item;
     */
    public function getItem()
    {
        return $this->_item;
    }
}
