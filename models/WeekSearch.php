<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Week;

/**
 * WeekSearch represents the model behind the search form of `app\models\Week`.
 */
class WeekSearch extends Week
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'week'], 'integer'],
            [['month', 'year', 'datestart', 'dateend'], 'safe'],
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
        $query = Week::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'datestart' => $this->datestart,
            'dateend' => $this->dateend,
            'week' => $this->week,
        ]);

        $query->andFilterWhere(['like', 'month', $this->month])
            ->andFilterWhere(['like', 'year', $this->year]);

        return $dataProvider;
    }
}
