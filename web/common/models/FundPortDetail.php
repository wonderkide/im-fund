<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fund_port_detail".
 *
 * @property int $id
 * @property int|null $fund_id
 * @property int|null $fund_invest_id
 * @property string $date
 * @property float $nav
 * @property float $amount
 * @property float $units
 * @property string $created_at
 * @property int $type 1=ซื้อ,2=ขาย,3=สับเปลี่ยนเข้า,4=สับเปลี่ยนออก
 * @property int $status 1=ปกติ,0=ลบ
 *
 * @property Fund $fund
 * @property FundPort $fundPort
 */
class FundPortDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fund_port_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fund_id', 'fund_port_id', 'type', 'status'], 'integer'],
            [['date', 'nav', 'amount', 'units', 'created_at', 'type'], 'required'],
            [['date', 'created_at'], 'safe'],
            [['nav', 'amount', 'units'], 'number'],
            [['fund_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fund::className(), 'targetAttribute' => ['fund_id' => 'id']],
            [['fund_port_id'], 'exist', 'skipOnError' => true, 'targetClass' => FundPort::className(), 'targetAttribute' => ['fund_port_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fund_id' => 'Fund ID',
            'fund_port_id' => 'Fund Port ID',
            'date' => 'Date',
            'nav' => 'Nav',
            'amount' => 'Amount',
            'units' => 'Units',
            'created_at' => 'Created At',
            'type' => 'Type',
            'status' => 'Status',
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
     * Gets query for [[FundInvest]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFundPort()
    {
        return $this->hasOne(FundPort::className(), ['id' => 'fund_port_id']);
    }
}
