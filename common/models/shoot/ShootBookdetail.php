<?php

namespace common\models\shoot;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

use common\models\User;
use common\models\shoot\ShootBookdetail;
use common\models\shoot\ShootSite;
use wskeee\rbac\RbacName;
use wskeee\framework\FrameworkManager;
use wskeee\framework\models\FWItem;

/**
 * This is the model class for table "{{%shoot_bookdetail}}".
 *
 * @property integer $id
 * @property integer $site_id 场地id
 * @property integer $fw_college
 * @property integer $fw_project
 * @property integer $fw_course
 * @property integer $lession_time
 * @property integer $u_teacher
 * @property integer $u_contacter
 * @property integer $u_booker
 * @property integer $u_shoot_man 摄影师
 * @property integer $book_time
 * @property integer $index
 * @property integer $shoot_mode
 * @property integer $photograph
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $ver
 * @property string $teacher_name 老师名称
 * @property int $teacher_phone 老师电话
 * @property string $teacher_email 老师邮箱
 * 
 * @property FrameworkItem $fwCollege
 * @property FrameworkItem $fwCourse
 * @property FrameworkItem $fwProject
 * @property User $booker
 * @property User $contacter
 * @property User $teacher
 * @property User $shootMan     摄影师
 * @property ShootSite $site 场地
 * @property array $appraiseResults 评价结束
 * @property array $appraises       评价题目
 */
class ShootBookdetail extends \yii\db\ActiveRecord
{
    /** 预约超时限制  */
    const BOOKING_TIMEOUT = 2*60;
    
    /** 默认状态 未预约 */
    const STATUS_DEFAULT = 0;
    /** 预约进行中 */
    const STATUS_BOOKING = 1;
    /** 委派状态,任务刚发出 */
    const STATUS_ASSIGN = 5;
    /** 拍摄中状态,已经分派摄影师，等待拍摄完成后评价 */
    const STATUS_SHOOTING = 10;
    /** 完成拍摄 评价状态 */
    const STATUS_APPRAISE = 13;
    /** 已完成,评价完成，任务结束 */
    const STATUS_COMPLETED = 15;
    /** 已失约,因其它问题导致在预定时间里没能完成拍摄任务，失约 */
    const STATUS_BREAK_PROMISE = 20;
    /** 已取消,因客观原因需要改期或者取消原定的拍摄任务，需要提前2天操作 */
    const STATUS_CANCEL = 99;
    
    /** 拍摄模式-标清 */
    const SHOOT_MODE_SD = 1;
    /** 拍摄模式-高清 */
    const SHOOT_MODE_HD = 2;
    
    /** 时段 上午 */
    const TIME_INDEX_MORNING = 0;
    /** 时段 下午 */
    const TIME_INDEX_AFTERNOON = 1;
    /** 时段 晚上 */
    const TIME_INDEX_NIGHT = 2;

    /** 状态列表 */
    public $statusMap = [
        self::STATUS_DEFAULT => '未预约',
        self::STATUS_BOOKING => '预约中',
        self::STATUS_ASSIGN => '待指派',
        self::STATUS_SHOOTING => '待评价',
        self::STATUS_APPRAISE => '评价中',
        self::STATUS_COMPLETED => '已完成',
        self::STATUS_BREAK_PROMISE => '已失约',
        self::STATUS_CANCEL => '已取消',
    ];
    
    /** 拍摄模式列表 */
    public $shootModeMap =[
        self::SHOOT_MODE_SD => '标清',
        self::SHOOT_MODE_HD => '高清',
    ];
    
    /** 时间段名称 */
    public $timeIndexMap = [
        self::TIME_INDEX_MORNING => '上',
        self::TIME_INDEX_AFTERNOON => '下',
        self::TIME_INDEX_NIGHT => '晚',
    ];
    
    /** 老师名称 */
    public $teacher_name;
    /** 老师电话 */
    public $teacher_phone;
    /** 老师邮箱 */
    public $teacher_email;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shoot_bookdetail}}';
    }
    
    public function behaviors() {
        return [
            TimestampBehavior::className()
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id','fw_college', 'fw_project', 'fw_course', 
                'lession_time', 'u_teacher', 'u_contacter', 
                'u_booker','u_shoot_man' ,'book_time', 'index', 'shoot_mode',
                'photograph', 'status', 'created_at', 'updated_at', 'ver'], 'integer'],
            [[
                'site_id',
                'fw_college', 'fw_project', 'fw_course', 
                'u_contacter', 'u_booker', 
                'book_time', 'index','teacher_name','teacher_phone'],'required'],
            [['teacher_phone'],'integer'],
            [['teacher_email'],'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('rcoa', 'ID'),
            'site_id' => Yii::t('rcoa', 'Site'),
            'fw_college' => Yii::t('rcoa', 'Fw College'),
            'fw_project' => Yii::t('rcoa', 'Fw Project'),
            'fw_course' => Yii::t('rcoa', 'Fw Course'),
            'lession_time' => Yii::t('rcoa', 'Lession Time'),
            'u_teacher' => Yii::t('rcoa', 'Teacher'),
            'u_contacter' => Yii::t('rcoa', 'Contacter'),
            'u_booker' => Yii::t('rcoa', 'Booker'),
            'u_shoot_man' => Yii::t('rcoa', 'Shoot Man'),
            'book_time' => Yii::t('rcoa', 'Book Time'),
            'index' => Yii::t('rcoa', 'Index'),
            'shoot_mode' => Yii::t('rcoa', 'Shoot Mode'),
            'photograph' => Yii::t('rcoa', 'Photograph'),
            'status' => Yii::t('rcoa', 'Status'),
            'created_at' => Yii::t('rcoa', 'Created At'),
            'updated_at' => Yii::t('rcoa', 'Updated At'),
            'teacher_name' => Yii::t('rcoa', 'Name'),
            'teacher_phone' => Yii::t('rcoa', 'Phone'),
            'teacher_email' => Yii::t('rcoa', 'Email'),
            'statusName' => Yii::t('rcoa', 'Status'),
            'teacher_email' => Yii::t('rcoa', 'Email'),
        ];
    }
    
    public function optimisticLock() {
        return 'ver';
    }
    
    public function afterFind() {
        parent::afterFind();
        if(!$this->isNewRecord)
        {
            $this->teacher_name = $this->teacher->nickname;
            $this->teacher_phone = $this->teacher->phone;
            $this->teacher_email = $this->teacher->email;
        }
    }
    
    public function beforeSave($insert){
        parent::beforeSave($insert);
        try
        {
            $user = User::find()
                    ->orWhere(['username'=>$this->teacher_phone])
                    ->orWhere(['nickname'=>$this->teacher_name])
                    ->one();
            if($user == null)
            {
                $user = new User();
                $user->username = $this->teacher_phone;
                $user->phone = $this->teacher_phone;
                $user->nickname = $this->teacher_name;
                $user->email = $this->teacher_email;
                $user->password = "123456";
                $user->auth_key = \Yii::$app->security->generateRandomString();
                $user->save();

                \Yii::$app->authManager->assign(\Yii::$app->authManager->getRole(RbacName::ROLE_TEACHERS), $user->id);
            }else
            {
                $user->nickname = $this->teacher_name;
                $user->email = $this->teacher_email;
                $user->phone = $this->teacher_phone;
                $user->save();
            }
            $this->u_teacher = $user->id;
            return true;
        } catch (\Exception $ex) {
            throw new \yii\web\NotFoundHttpException("创建老师账号出错！".$ex->getMessage());
            return false;
        }
    }
    
    /**
     * 场地
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(ShootSite::className(), ['id' => 'site_id']);
    }

    /**
     * @return FWItem
     */
    public function getFwCourse()
    {
        /* @var $fwManager FrameworkManager */
        $fwManager = Yii::$app->get('fwManager');
        return $fwManager->getItemById($this->fw_course);
    }

    /**
     * @return FWItem
     */
    public function getFwProject()
    {
        /* @var $fwManager FrameworkManager */
        $fwManager = Yii::$app->get('fwManager');
        return $fwManager->getItemById($this->fw_project);
    }
    
    /**
     * @return FWItem
     */
    public function getFwCollege()
    {
        /* @var $fwManager FrameworkManager */
        $fwManager = Yii::$app->get('fwManager');
        return $fwManager->getItemById($this->fw_college);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooker()
    {
        return $this->hasOne(User::className(), ['id' => 'u_booker']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacter()
    {
        return $this->hasOne(User::className(), ['id' => 'u_contacter']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(User::className(), ['id' => 'u_teacher']);
    }
    
    /**
     * 获取摄影师
     * @return \yii\db\ActiveQuery
     */
    public function getShootMan()
    {
        return $this->hasOne(User::className(), ['id' => 'u_shoot_man']);
    }
    /**
     * 获取所有评价结果
     * @return \yii\db\ActiveQuery
     */
    public function getAppraiseResults()
    {
        return $this->hasMany(ShootAppraiseResult::className(), ['b_id'=>'id']);
    }
    
    /**
     * 获取所有评价题目
     * @return \yii\db\ActiveQuery
     */
    public function getAppraises()
    {
        return $this->hasMany(ShootAppraise::className(), ['b_id'=>'id']);
    }
    
    /**
     * 获取评价详细数据
     * @return array(u_contacter=>['hasDo'=>true,sum=>0,all=>1],u_shoot_man=>[...])
     * 
     */
    public function getAppraiseInfo()
    {
        /** 总得分 */
        $sum = 0;
        /** 总分 */
        $all = 0;
        
    }
    
    /**
     * 获取状态显示
     * @return string
     */
    public function getStatusName()
    {
        return $this->statusMap[$this->status];
    }
    
    /**
     * 获取是否为【未预约】
     * @return bool
     */
    public function getIsNew()
    {
        return $this->status == self::STATUS_DEFAULT;
    }
    
    /**
     * 是否在【预约中】状态
     * @return bool 
     */
    public function getIsBooking()
    {
        return $this->status == self::STATUS_BOOKING && (time() - $this->updated_at <= BOOKING_TIMEOUT);
    }
    
    /**
     * 是否在【待指派】状态
     */
    public function getIsAssign()
    {
        return $this->status == self::STATUS_ASSIGN;
    }
    /**
     * 是否在可以执行指派操作
     */
    public function canAssign()
    {
        return $this->status <= self::STATUS_SHOOTING;
    }
    
    /**
     * 是否可以执行更新操作
     */
    public function canEdit()
    {
        return $this->status < self::STATUS_SHOOTING;
    }
    
    /**
     * 是否在【评价中】状态
     */
    public function getIsAppraise()
    {
        return $this->status == self::STATUS_APPRAISE;
    }
    
    /**
     * 是否可以执行/查看【评价】操作
     */
    public function canAppraise()
    {
        return $this->status >= self::STATUS_SHOOTING;
    }
    
    /**
     * 获取拍摄模式
     * @return string
     */
    public function getShootModeName()
    {
        return $this->shootModeMap[$this->shoot_mode];
    }
    
    /**
     * 获取时间段名称
     * @return string
     */
    public function getTimeIndexName()
    {
        return $this->timeIndexMap[$this->index];
    }
}
