<?php

namespace common\models\question;

use Yii;

/**
 * This is the model class for table "{{%question_op}}".
 *
 * @property integer $id
 * @property integer $question_id
 * @property integer $type
 * @property string $title
 * @property string $value
 */
class QuestionOp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%question_op}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'type'], 'integer'],
            [['title', 'value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('rcoa', 'ID'),
            'question_id' => Yii::t('rcoa', 'Question ID'),
            'type' => Yii::t('rcoa', 'Type'),
            'title' => Yii::t('rcoa', 'Title'),
            'value' => Yii::t('rcoa', 'Value'),
        ];
    }
}
