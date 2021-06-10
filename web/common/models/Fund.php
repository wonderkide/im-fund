<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fund".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $fund_type_id
 * @property int|null $fund_type_in_id
 * @property int|null $asset_management_id
 * @property string $name
 * @property string|null $name_th
 * @property int $risk
 * @property string|null $feeder_fund
 * @property int $currency_policy 1=ป้องกัน,2=ไม่ป้องกัน,3=ป้องกันบางส่วน,4=ดุลพินิจ
 * @property int $dividend 0=ไม่จ่าย,1=จ่าย
 * @property float $frontend_fee ค่าธรรมเนียมขาย
 * @property float $backend_fee ค่าธรรมเนียมรับซื้อคืน
 * @property float $fee ค่าธรรมเนียมจัดการ
 * @property float|null $first_invest ลงทุนครั้งแรก
 * @property float|null $invest ลงทุนครั้งถัดไป
 * @property string|null $registration_date
 * @property float|null $net_asset_value
 * @property string|null $detail
 *
 * @property AssetManagement $assetManagement
 * @property FundInvestDetail[] $fundInvestDetails
 * @property FundInvest[] $fundInvests
 * @property FundType $fundType
 * @property FundTypeIn $fundTypeIn
 */
class Fund extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fund';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'fund_type_id', 'fund_type_in_id', 'asset_management_id', 'risk', 'currency_policy', 'dividend'], 'integer'],
            [['name', 'risk', 'dividend'], 'required'],
            [['frontend_fee', 'backend_fee', 'fee', 'first_invest', 'invest', 'net_asset_value'], 'number'],
            [['registration_date'], 'safe'],
            [['detail'], 'string'],
            [['name', 'name_th', 'feeder_fund'], 'string', 'max' => 255],
            [['asset_management_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssetManagement::className(), 'targetAttribute' => ['asset_management_id' => 'id']],
            [['fund_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => FundType::className(), 'targetAttribute' => ['fund_type_id' => 'id']],
            [['fund_type_in_id'], 'exist', 'skipOnError' => true, 'targetClass' => FundTypeIn::className(), 'targetAttribute' => ['fund_type_in_id' => 'id']],
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
            'fund_type_id' => 'Fund Type ID',
            'fund_type_in_id' => 'Fund Type In ID',
            'asset_management_id' => 'Asset Management ID',
            'name' => 'Name',
            'name_th' => 'Name Th',
            'risk' => 'Risk',
            'feeder_fund' => 'Feeder Fund',
            'currency_policy' => 'Currency Policy',
            'dividend' => 'Dividend',
            'frontend_fee' => 'Frontend Fee',
            'backend_fee' => 'Backend Fee',
            'fee' => 'Fee',
            'first_invest' => 'First Invest',
            'invest' => 'Invest',
            'registration_date' => 'Registration Date',
            'net_asset_value' => 'Net Asset Value',
            'detail' => 'Detail',
        ];
    }

    /**
     * Gets query for [[AssetManagement]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssetManagement()
    {
        return $this->hasOne(AssetManagement::className(), ['id' => 'asset_management_id']);
    }

    /**
     * Gets query for [[FundInvestDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFundInvestDetails()
    {
        return $this->hasMany(FundInvestDetail::className(), ['fund_id' => 'id']);
    }

    /**
     * Gets query for [[FundInvests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFundInvests()
    {
        return $this->hasMany(FundInvest::className(), ['fund_id' => 'id']);
    }

    /**
     * Gets query for [[FundType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFundType()
    {
        return $this->hasOne(FundType::className(), ['id' => 'fund_type_id']);
    }

    /**
     * Gets query for [[FundTypeIn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFundTypeIn()
    {
        return $this->hasOne(FundTypeIn::className(), ['id' => 'fund_type_in_id']);
    }
}
