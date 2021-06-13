<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fund_port".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $name
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
class FundPort extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fund_port';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['present_value', 'cost_value', 'present_nav', 'cost_nav', 'units'], 'number'],
            [['created_at', 'name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
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
     * Gets query for [[FundInvestDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFundPortDetails()
    {
        return $this->hasMany(FundPortDetail::className(), ['fund_port_id' => 'id']);
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
