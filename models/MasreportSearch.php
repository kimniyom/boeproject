<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Masreport;

/**
 * MasreportSearch represents the model behind the search form of `app\models\Masreport`.
 */
class MasreportSearch extends Masreport
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reportid', 'active'], 'integer'],
            [['reportname', 'note'], 'safe'],
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
        $query = Masreport::find();

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
            'reportid' => $this->reportid,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'reportname', $this->reportname])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
