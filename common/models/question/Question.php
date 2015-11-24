<?php

namespace common\models\question;

use Yii;

/**
 * This is the model class for table "{{%question}}".
 *
 * @property integer $id
 * @property integer $type
 * @property string $title
 * @property string $des
 */
class Question extends \yii\db\ActiveRecord
{
    /** 单项选择题 */
    const TYPE_SINGLE_CHOICE = 1;
    /** 多项选择题 */
    const TYPE_MULTIPLE_CHOICE = 2;
    
    /** 类型 */
    public static $TYPES = [
        self::TYPE_SINGLE_CHOICE => '单项选择题',
        self::TYPE_MULTIPLE_CHOICE => '多项选择题',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%question}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'integer'],
            [['title', 'des'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('rcoa', 'ID'),
            'type' => Yii::t('rcoa', 'Type'),
            'title' => Yii::t('rcoa', 'Title'),
            'des' => Yii::t('rcoa', 'Des'),
        ];
    }
    
    /**
     * 所有选项
     * @return \yii\db\ActiveQuery
     */
    public function getOps()
    {
        return $this->hasMany(QuestionOp::className(), ['question_id' => 'id']);
    }
    
    /** 获取类型名 */
    public function getTypeName()
    {
        return self::$TYPES[$this->type];
    }
}
