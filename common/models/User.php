<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

//use wskeee\rbac\RbacManager;


/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username   用户名
 * @property string $nickname   昵称
 * @property string $auth_key
 * @property string password
 * @property string $password_reset_token
 * @property string $email
 * @property string $ee         ee号
 * @property string $phone      手机
 * @property string $avatar     头像
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    /** 创建场景 */
    const SCENARIO_CREATE = 'create';
    /** 更新场景 */
    const SCENARIO_UPDATE = 'update';
    
    //已删除账号
    const STATUS_DELETED = 0;
    //活动账号
    const STATUS_ACTIVE = 10;
    
    /* 重复密码验证 */
    public $password2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }
    
    public function scenarios() 
    {
        return [
            self::SCENARIO_CREATE => ['username','nickname','email','password','password2','email','ee','phone','avatar'],
            self::SCENARIO_UPDATE => ['username','nickname','email','password','password2','email','ee','phone','avatar'],
            self::SCENARIO_DEFAULT => ['username','nickname']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors() 
    {
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
            [['password','password2'],'required','on'=>[self::SCENARIO_CREATE]],
            [['username','nickname','email'],'required','on'=>[self::SCENARIO_CREATE,self::SCENARIO_UPDATE]],
            [['username','email'],'unique'],
            [['password'],'string', 'min'=>6, 'max'=>20],
            [['username'],'string', 'max'=>32, 'on'=>['create']],
            [['username','nickname', 'password', 'password_reset_token', 'email','avatar','ee','phone'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 255],
            [['password_reset_token'], 'unique'],
            [['email'], 'email'],
            [['password2'],'compare','compareAttribute'=>'password'],
            [['avatar'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'nickname' => '昵称',
            'auth_key' => '授权码',
            'password' => '密码',
            'password2'=>'确认密码',
            'password_reset_token' => '密码重置令牌',
            'email' => '邮箱',
            'ee' => 'EE',
            'phone' => '手机',
            'status' => '状态',
            'avatar' => '头像',
            'created_at' => '创建于',
            'updated_at' => '更新于',
        ];
    }
    
    /**
     * 根据id查找
     * @param type $id
     * @return type common\models\User
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id,'status'=>  self::STATUS_ACTIVE]);
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }
    
    
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    
    /**
     * @inherdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    
    /**
     * 检查用户是否属于 ｛roleName｝ 角色
     * @param string $roleName 角色名
     * @return bool
     */
    private function isRole($roleName)
    {
        /* @var $authManager RbacManager */
        //$authManager = Yii::$app->authManager;
        //return $authManager->isRole($roleName, $this->id);
    }
    
    /**
     * 验证授权码
     * @param type $authKey 授权码
     * @return type boolean
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }
    
    /**
     * 设置密码
     * @param type $password
     */
    public function setPassword($password)
    {
        $this->password = \Yii::$app->security->generatePasswordHash($password);
    }
    
    /**
     * 密码验证
     * @param type $password    待验证密码
     * @return type boolean
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }
    
    /**
     * 生成密码重致令牌
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = \Yii::$app->security->generateRandomString().'_'.time();
    }
    
    /**
     * 删除密码重致令牌
     */
    public function removePasswordResetToken()
    {
        $this->password = null;
    }
    
    /**
     * 
     * @param type $insert 
     */
    public function beforeSave($insert) 
    {
        if(parent::beforeSave($insert))
        {
            $upload = UploadedFile::getInstance($this, 'avatar');
            if($upload != null)
            {
                $uploadpath = $this->fileExists(Yii::getAlias('@filedata').'/avatars/');
                $upload->saveAs($uploadpath.$this->username.'.jpg');
                $this->avatar = FILEDATA_PATH.'avatars/'.$this->username.'.jpg';
            }
            
            if($this->scenario == self::SCENARIO_CREATE)
            {
                $this->setPassword($this->password);
            }else if($this->scenario ==  self::SCENARIO_UPDATE)
            {
                if(trim($this->password) == '')
                    $this->password = $this->getOldAttribute ('password');
                else
                    $this->setPassword ($this->password);
                
                if(trim($this->avatar) == '')
                    $this->avatar = $this->getOldAttribute ('avatar');
            }
            
            if($this->scenario == self::SCENARIO_CREATE)
                $this->generateAuthKey();
            
            if(trim($this->nickname) == '')
                $this->nickname = $this->username;
            
            return true;
        }else
            return false;
    }
    
    /**
     * 检查目标路径是否存在，不存即创建目标
     * @param string $uploadpath    目录路径
     * @return string
     */
    private function fileExists($uploadpath) {

        if (!file_exists($uploadpath)) {
            mkdir($uploadpath);
        }
        return $uploadpath;
    }
}
