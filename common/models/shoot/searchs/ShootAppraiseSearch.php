<?php

namespace common\models\shoot\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\shoot\ShootAppraise;

/**
 * ShootAppraiseSearch represents the model behind the search form about `common\models\shoot\ShootAppraise`.
 */
class ShootAppraiseSearch extends ShootAppraise
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_name'], 'safe'],
            [['b_id','q_id', 'index'], 'integer'],
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
        $query = ShootAppraise::find();

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
            'q_id' => $this->q_id,
            'index' => $this->index,
        ]);

        $query->andFilterWhere(['like', 'role_name', $this->role_name]);

        return $dataProvider;
    }
}
