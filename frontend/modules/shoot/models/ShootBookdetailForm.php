<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\shoot\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

use common\models\User;
use common\models\shoot\ShootBookdetail;
use wskeee\rbac\RbacName;

/**
 * Description of ShootBookdetailForm
 * @property string $teacher_name 老师名称
 * @property int $teacher_phone 老师电话
 * @property string $teacher_email 老师邮箱
 * @author Administrator
 */
class ShootBookdetailForm extends ShootBookdetail
{
    /** 老师名称 */
    public $teacher_name;
    /** 老师电话 */
    public $teacher_phone;
    /** 老师邮箱 */
    public $teacher_email;
    
    public function behaviors() {
        return [
            TimestampBehavior::className()
        ];
    }
    
    public function rules() {
        return ArrayHelper::merge(parent::rules(), [
            [['teacher_name','teacher_phone'],'required'],
            [['teacher_phone'],'integer'],
            [['teacher_email'],'email'],
        ]);
    }
    
    public function attributeLabels() {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'teacher_name' => Yii::t('rcoa', 'Name'),
            'teacher_phone' => Yii::t('rcoa', 'Phone'),
            'teacher_email' => Yii::t('rcoa', 'Email'),
        ]);
    }
    
    public function init() {
        parent::init();
        if(!$this->isNewRecord)
        {
            $this->teacher_name = $this->getTeacher()->username;
            $this->teacher_phone = $this->getTeacher()->phone;
            $this->teacher_email = $this->getTeacher()->email;
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
}
