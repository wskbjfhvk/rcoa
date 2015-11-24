<?php

namespace common\models\shoot;

use common\models\question\Question;
use wskeee\rbac\models\AuthItem;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\User;

/**
 * This is the model class for table "{{%shoot_appraise_result}}".
 *
 * @property integer $b_id
 * @property integer $u_id
 * @property integer $q_id
 * @property string $role_name
 * @property integer $value
 * @property string $data
 *
 * @property ShootBookdetail $bookdetail
 * @property AuthItem $role
 * @property User $user
 */
class ShootAppraiseResult extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shoot_appraise_result}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['b_id', 'u_id','q_id'], 'required'],
            [['b_id', 'u_id','q_id', 'value'], 'integer'],
            [['role_name'], 'string', 'max' => 64],
            [['data'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'b_id' => Yii::t('rcoa', 'B ID'),
            'u_id' => Yii::t('rcoa', 'User'),
            'q_id' => Yii::t('rcoa', 'QuestionID'),
            'role_name' => Yii::t('rcoa', 'Role'),
            'value' => Yii::t('rcoa', 'Value'),
            'data' => Yii::t('rcoa', 'Data'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getBookdetail()
    {
        return $this->hasOne(ShootBookdetail::className(), ['id' => 'b_id']);
    }
    /**
     * @return ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'q_id']);
    }

    /**
     * @return AuthItem
     */
    public function getRole()
    {
        return \Yii::$app->authManager->getRole($this->role_name);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'u_id']);
    }
}
