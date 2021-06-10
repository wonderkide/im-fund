<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fund_invest".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $fund_id
 * @property float $present_value
 * @property float $cost_value
 * @property float $present_nav
 * @property float $cost_nav
 * @property float $units
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Fund $fund
 * @property FundInvestDetail[] $fundInvestDetails
 * @property User $user
 */
class FundInvest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fund_invest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'fund_id'], 'integer'],
            [['present_value', 'cost_value', 'present_nav', 'cost_nav', 'units'], 'number'],
            [['created_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['fund_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fund::className(), 'targetAttribute' => ['fund_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'fund_id' => 'Fund ID',
            'present_value' => 'Present Value',
            'cost_value' => 'Cost Value',
            'present_nav' => 'Present Nav',
            'cost_nav' => 'Cost Nav',
            'units' => 'Units',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Fund]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFund()
    {
        return $this->hasOne(Fund::className(), ['id' => 'fund_id']);
    }

    /**
     * Gets query for [[FundInvestDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFundInvestDetails()
    {
        return $this->hasMany(FundInvestDetail::className(), ['fund_invest_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
