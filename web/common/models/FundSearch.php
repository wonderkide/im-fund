<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Fund;

/**
 * FundSearch represents the model behind the search form of `common\models\Fund`.
 */
class FundSearch extends Fund
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fund_type_id', 'fund_type_in_id', 'asset_management_id', 'risk', 'currency_policy', 'dividend'], 'integer'],
            [['name_en', 'name_th', 'feeder_fund', 'registration_date', 'detail', 'amc_id', 'proj_id', 'symbol', 'fund_connext_id'], 'safe'],
            [['frontend_fee', 'backend_fee', 'fee', 'first_invest', 'invest', 'net_asset_value'], 'number'],
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
        $query = Fund::find();
        
        $query->joinWith('assetManagement');

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
            'fund_type_id' => $this->fund_type_id,
            'fund_type_in_id' => $this->fund_type_in_id,
            'asset_management_id' => $this->asset_management_id,
            'risk' => $this->risk,
            'currency_policy' => $this->currency_policy,
            'dividend' => $this->dividend,
            'frontend_fee' => $this->frontend_fee,
            'backend_fee' => $this->backend_fee,
            'fee' => $this->fee,
            'first_invest' => $this->first_invest,
            'invest' => $this->invest,
            'registration_date' => $this->registration_date,
            'net_asset_value' => $this->net_asset_value,
        ]);

        $query->andFilterWhere(['like', 'name_en', $this->name_en])
                ->andFilterWhere(['like', 'symbol', $this->symbol])
            ->andFilterWhere(['like', 'name_th', $this->name_th])
            ->andFilterWhere(['like', 'feeder_fund', $this->feeder_fund])
            ->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }
}
