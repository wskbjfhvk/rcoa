<?php

namespace common\models\shoot;

use common\models\question\Question;
use wskeee\rbac\models\AuthItem;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rcoa_shoot_appraise".
 *
 * @property integer $b_id
 * @property string $role_name
 * @property integer $q_id
 * @property integer $value 分值
 * @property integer $index
 *
 * @property ShootBookdetail $bookdetail
 * @property Question $question
 * @property AuthItem $role
 */
class ShootAppraise extends ShootAppraiseTemplate
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shoot_appraise}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['b_id'],'integer'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'b_id' => Yii::t('rcoa', 'B ID'),
        ]);
    }
    
    /**
     * @return ActiveQuery
     */
    public function getBookdetail()
    {
        return $this->hasOne(ShootBookdetail::className(), ['id' => 'b_id']);
    }
}
