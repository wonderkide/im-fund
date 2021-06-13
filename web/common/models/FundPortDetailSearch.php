<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FundPortDetail;

/**
 * FundPortDetailSearch represents the model behind the search form of `common\models\FundPortDetail`.
 */
class FundPortDetailSearch extends FundPortDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fund_id', 'fund_port_id', 'type', 'status'], 'integer'],
            [['date', 'created_at'], 'safe'],
            [['nav', 'amount', 'units'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = FundPortDetail::find();

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
            'fund_id' => $this->fund_id,
            'fund_port_id' => $this->fund_port_id,
            'date' => $this->date,
            'nav' => $this->nav,
            'amount' => $this->amount,
            'units' => $this->units,
            'created_at' => $this->created_at,
            'type' => $this->type,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
