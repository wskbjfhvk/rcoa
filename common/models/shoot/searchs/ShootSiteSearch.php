<?php

namespace common\models\shoot\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\shoot\ShootSite;

/**
 * ShootSiteSearch represents the model behind the search form about `common\models\shoot\ShootSite`.
 */
class ShootSiteSearch extends ShootSite
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'traffic', 'des'], 'safe'],
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
        $query = ShootSite::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'traffic', $this->traffic])
            ->andFilterWhere(['like', 'des', $this->des]);

        return $dataProvider;
    }
}
