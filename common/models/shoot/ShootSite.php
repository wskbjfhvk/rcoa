<?php

namespace common\models\shoot;

use Yii;

/**
 * This is the model class for table "{{%shoot_site}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $traffic
 * @property string $des
 *
 * @property ShootSiteRule[] $shootSiteRules
 */
class ShootSite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shoot_site}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 64],
            [['traffic', 'des'], 'string', 'max' => 255]
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
            'traffic' => Yii::t('rcoa', 'Traffic'),
            'des' => Yii::t('rcoa', 'Des'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShootSiteRules()
    {
        return $this->hasMany(ShootSiteRule::className(), ['site' => 'id']);
    }
}
