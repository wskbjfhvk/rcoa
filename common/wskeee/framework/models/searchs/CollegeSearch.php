<?php

namespace wskeee\framework\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use wskeee\framework\models\College;

/**
 * CollegeSearch represents the model behind the search form about `wskeee\framework\models\College`.
 */
class CollegeSearch extends College
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level', 'create_at', 'updated_at', 'parent_id'], 'integer'],
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
        $query = College::find();

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
            'level' => $this->level,
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'des', $this->des]);

        return $dataProvider;
    }
}
