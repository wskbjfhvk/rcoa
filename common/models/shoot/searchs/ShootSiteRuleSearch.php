<?php

namespace common\models\shoot\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\shoot\ShootSiteRule;

/**
 * ShootSiteRuleSearch represents the model behind the search form about `common\models\shoot\ShootSiteRule`.
 */
class ShootSiteRuleSearch extends ShootSiteRule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'site', 'start_time', 'end_time'], 'integer'],
            [['name', 'des'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ShootSiteRule::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'site' => $this->site,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'des', $this->des]);

        return $dataProvider;
    }
}
