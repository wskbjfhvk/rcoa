<?php

namespace common\models\shoot\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\shoot\ShootAppraiseResult;

/**
 * ShootAppraiseResultSearch represents the model behind the search form about `common\models\shoot\ShootAppraiseResult`.
 */
class ShootAppraiseResultSearch extends ShootAppraiseResult
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['b_id', 'u_id', 'value'], 'integer'],
            [['role_name', 'data'], 'safe'],
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
        $query = ShootAppraiseResult::find();

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
            'b_id' => $this->b_id,
            'u_id' => $this->u_id,
            'value' => $this->value,
        ]);

        $query->andFilterWhere(['like', 'role_name', $this->role_name])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
