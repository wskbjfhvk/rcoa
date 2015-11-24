<?php

namespace common\models\shoot;

use Yii;

/**
 * This is the model class for table "{{%shoot_site_rule}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property integer $site
 * @property integer $start_time
 * @property integer $end_time
 * @property string $des
 *
 * @property ShootSite $site0
 */
class ShootSiteRule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shoot_site_rule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'site', 'start_time', 'end_time'], 'integer'],
            [['name', 'des'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('rcoa', 'ID'),
            'name' => Yii::t('rcoa', 'Name'),
            'type' => Yii::t('rcoa', 'Type'),
            'site' => Yii::t('rcoa', 'Site'),
            'start_time' => Yii::t('rcoa', 'Start Time'),
            'end_time' => Yii::t('rcoa', 'End Time'),
            'des' => Yii::t('rcoa', 'Des'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSite0()
    {
        return $this->hasOne(ShootSite::className(), ['id' => 'site']);
    }
}
