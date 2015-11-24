<?php

namespace common\models\shoot;

use Yii;
use common\models\question\Question;

/**
 * This is the model class for table "{{%shoot_appraise}}".
 *
 * @property string $role_name
 * @property integer $q_id
 * @property integer $value 得分
 * @property integer $index
 *
 * @property Question $question
 * @property AuthItem $role
 */
class ShootAppraiseTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shoot_appraise_template}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_name', 'q_id'], 'required'],
            [['q_id','value', 'index'], 'integer'],
            [['role_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role_name' => Yii::t('rcoa', 'Role'),
            'q_id' => Yii::t('rcoa', 'Question'),
            'value' => \Yii::t('rcoa', 'Value'),
            'index' => Yii::t('rcoa', 'Index'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'q_id']);
    }

    /**
     * @return \wskeee\rbac\models\AuthItem
     */
    public function getRole()
    {
        return \Yii::$app->authManager->getRole($this->role_name);
    }
}
