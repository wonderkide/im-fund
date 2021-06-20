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
 * @property float|null $nav
 * @property string|null $nav_date
 * @property int $risk
 * @property string|null $feeder_fund
 * @property int $currency_policy 1=ป้องกัน,2=ไม่ป้องกัน,3=ป้องกันบางส่วน,4=ดุลพินิจ
 * @property string|null $currency_policy_text
 * @property int $dividend 0=ไม่จ่าย,1=จ่าย
 * @property float $frontend_fee ค่าธรรมเนียมขาย
 * @property float $backend_fee ค่าธรรมเนียมรับซื้อคืน
 * @property float $fee ค่าธรรมเนียมจัดการ
 * @property float|null $first_invest ลงทุนครั้งแรก
 * @property float|null $invest ลงทุนครั้งถัดไป
 * @property string|null $registration_date
 * @property string|null $registration_date_text
 * @property float|null $net_asset_value
 * @property string|null $detail
 *
 * @property AssetManagement $assetManagement
 * @property FundInvestDetail[] $fundInvestDetails
 * @property FundInvest[] $fundInvests
 * @property FundType $fundType
 * @property FundTypeIn $fundTypeIn
 * @property int|null $content_status
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
            [['user_id', 'fund_type_id', 'fund_type_in_id', 'asset_management_id', 'risk', 'currency_policy', 'dividend', 'content_status'], 'integer'],
            [['user_id', 'fund_type_id', 'fund_type_in_id', 'asset_management_id','name', 'risk', 'dividend'], 'required'],
            [['frontend_fee', 'backend_fee', 'fee', 'first_invest', 'invest', 'net_asset_value', 'nav'], 'number'],
            [['registration_date', 'nav_date'], 'safe'],
            [['detail'], 'string'],
            [['name', 'name_th', 'feeder_fund', 'registration_date_text'], 'string', 'max' => 255],
            [['currency_policy_text'], 'string', 'max' => 512],
            
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
            'user_id' => 'ผู้ใช้งาน',
            'fund_type_id' => 'ประเภท',
            'fund_type_in_id' => 'ประเภทกองทุน',
            'asset_management_id' => 'บลจ.',
            'name' => 'รหัสกองทุน',
            'name_th' => 'ชื่อกองทุน',
            'risk' => 'ความเสี่ยง',
            'feeder_fund' => 'Feeder Fund',
            'currency_policy' => 'นโยบายค่าเงิน',
            'dividend' => 'นโยบายจ่ายปัยผล',
            'frontend_fee' => 'ค่าธรรมเนียมขาย',
            'backend_fee' => 'ค่าธรรมเนียมซื้อ',
            'fee' => 'ค่าจัดการ',
            'first_invest' => 'ลงทุนครั้งแรก',
            'invest' => 'ลงทุนครั้งต่อไป',
            'registration_date' => 'วันจดทะเบียน',
            'net_asset_value' => 'มูลค่ากอง',
            'detail' => 'รายละเอียดเพิ่มเติม',
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
    
    public function getCurrencyPolicyList(){
        $arr = [
            1 => 'ป้องกัน',
            2 => 'ไม่ป้องกัน',
            3 => 'ป้องกันบางส่วน',
            4 => 'ดุลพินิจ	',
        ];
        return $arr;
    }
}
