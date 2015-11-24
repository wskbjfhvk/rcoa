<?php

namespace wskeee\rbac\models\searchs;

use Yii;
use yii\base\Model;
use yii\rbac\Item;
use yii\data\ArrayDataProvider;

/**
 * AuthItemSearch
 */
class AuthItemSearch extends Model
{
    public $name;
    public $type;
    public $description;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'safe'],
            [['type'], 'integer'],
        ];
    }

    /**
     * 查找 authitem 认证
     *
     * @param array $params 过滤数据
     *
     * @return yii\data\ArrayDataProvider
     */
    public function search($params)
    {
        /* @var yii\rbac\AuthManager $authManager */
        $authManager = Yii::$app->authManager;
        
        if($this->type == Item::TYPE_ROLE)
            $items = $authManager->getRoles();
        else
            $items = $authManager->getPermissions();
        
        if($this->load($params) && $this->validate() && (trim($this->name)!=='' || trim($this->description)!==''))
        {
            $name = strtolower(trim($this->name));
            $des = strtolower(trim($this->description));
            $items = array_filter($items, function($item) use($name,$des)
                    {
                        return (empty($name) || strpos(strtolower($item->name), $name) !== false) 
                                && (empty($des) || strpos(strtolower($item->description), $des) !== false);
                    });
        }
        return new ArrayDataProvider([
            'allModels'=>$items
        ]);
    }
}
