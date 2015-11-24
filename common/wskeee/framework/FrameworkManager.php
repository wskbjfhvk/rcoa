<?php
namespace wskeee\framework;

use yii\caching\Cache;
use yii\db\Query;
use yii\di\Instance;
use yii\db\Connection;
use linslin\yii2\curl\Curl;

use wskeee\framework\models\FWItem;
use wskeee\framework\models\Item;

/**
 * Description of ProjectManager
 *
 * @author wskeee
 */
class FrameworkManager extends \yii\base\Component 
{
    /*
     * @var  $time_out 超时时长
     */
    const TIME_OUT = 30*60;
    
    public $url = '';
    /**
     * @var Cache|array|string the cache used to improve framework performance. This can be one of the following:
     *
     * - an application component ID (e.g. `cache`)
     * - a configuration array
     * - a [[\yii\caching\Cache]] object
     *
     * When this is not set, it means caching is not enabled.
     */
    public $cache;
    /**
     * @var string the key used to store 项目 data in cache
     * @see cache
     * @since 1.0.0
     */
    public $cacheKey = 'wskeee_framework';

    /**
     * @var FWItem[] all auth items (name => FWItem)
     */
    protected $items;
    /**
     * @var array 项目之间关系 (childName => list of parents)
     */
    protected $parents;
    
    /**
     * @var array 项目与子项关系(name => list of child) 
     */
    protected $childs;


    public function init() 
    {
        parent::init();
        if ($this->cache !== null) {
            $this->cache = Instance::ensure($this->cache, Cache::className());
        }
        
        $this->loadFromCache();
    }
    
    /**
     * 获取架构数据
     * @param int $itemId
     * @return FWItem
     */
    public function getItemById($itemId)
    {
        return $this->items[$itemId];
    }
    
    /**
     * return array 所有学院数据
     */
    public function getColleges()
    {
        $items = [];
        foreach($this->items as $id => $item)
        {
            if($item->level == FWItem::LEVEL_COLLEGE)
                $items [] = $item;
        }
        return $items;
    }
    
    /**
     * 
     * @return array 所有项目数据
     */
    public function getProjects()
    {
        $items = [];
        foreach($this->items as $id => $item)
        {
            if($item->level == FWItem::LEVEL_PROJECT)
                $items [] = $item;
        }
        return $items;
    }
    
    /**
     * 
     * @return array 所有课程数据
     */
    public function getCourses()
    {
        $items = [];
        
        foreach($this->items as $id => $item)
        {
            if($item->level == FWItem::LEVEL_COURSE)
                $items [] = $item;
        }
        return $items;
    }

    /**
     * 获取 itemId 的子项目
     * @param int $itemId 项目id
     * @return array 子项目
     */
    public function getChildren($itemId)
    {
        return $this->childs[$itemId];
    }
    
    /**
     * 取消缓存
     */
    public function invalidateCache() 
    {
        if(!$this->cache !== null)
        {
            $this->cache->delete($this->cacheKey);
            $this->items = null;
            $this->parents = null;
            $this->childs = null;
        }
    }

    /**
     * 从缓存中获取数据
     */
    public function loadFromCache()
    {
        if ($this->items !== null || !$this->cache instanceof Cache) {
            return;
        }
        $data = $this->cache->get($this->cacheKey);
        $time;
        if(is_array($data) && (isset($data[2]) && (time() - $data[2]<self::TIME_OUT)) && isset($data[0],$data[1],$data[2]))
        {
            list($this->items,$this->childs,$time) = $data;
            return;
        }
        
        \Yii::trace('【Curl】请求最新项目数据！url='.$this->url, 'framework');
        $curl = new Curl();
        $response = $curl->setOption(CURLOPT_RETURNTRANSFER,true)->get($this->url);
        
        switch ($curl->responseCode) {
 
            case 'timeout':
                \Yii::error("加载 framework 数据失败！【timeout】");
                break;
 
            case 200:
                $this->items = [];
                $datas = json_decode($response,true);
                foreach ($datas["data"] as $item)
                    $this->items[$item["id"]] = $this->populateItem($item);
                
                $this->childs = [];
                foreach($this->items as $id => $item)
                {
                    if($item->parent_id !== null)
                        $this->childs[$item->parent_id][] = $item;
                }
                $this->cache->set($this->cacheKey, [$this->items,$this->childs,  time()]);
                break;
 
            case 404:
                \Yii::error("加载 framework 数据失败！【404】");
                throw new \yii\base\UserException("加载 framework 数据失败！【404】");
                break;
        }
    }
    
    /**
     * @var $item ['id','name','level','parent_id','des','created_at','updated_at']
     */
    private function populateItem($item)
    {
        return new FWItem($item);
    }
}
