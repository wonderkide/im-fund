<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FundPortList;

/**
 * FundPortListSearch represents the model behind the search form of `common\models\FundPortList`.
 */
class FundPortListSearch extends FundPortList
{
    public $fund_name;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'fund_port_id', 'fund_id'], 'integer'],
            [['present_value', 'cost_value', 'present_nav', 'cost_nav', 'units', 'percent', 'ratio', 'profit'], 'number'],
            [['created_at', 'updated_at', 'fund_name'], 'safe'],
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
        $query = FundPortList::find()/*->select('fund_port_list.*, fund.name AS fund_name')*/->joinWith('fund');

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
            'user_id' => $this->user_id,
            'fund_port_id' => $this->fund_port_id,
            'fund_id' => $this->fund_id,
            'present_value' => $this->present_value,
            'cost_value' => $this->cost_value,
            'present_nav' => $this->present_nav,
            'cost_nav' => $this->cost_nav,
            'units' => $this->units,
            'profit' => $this->profit,
            'percent' => $this->percent,
            'ratio' => $this->ratio,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'fund.symbol' => $this->fund_id,
        ]);
        
        //$query->andFilterWhere(['like', 'name', $this->fund_id]);

        return $dataProvider;
    }
    
}
