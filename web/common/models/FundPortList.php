<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fund_port_list".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $fund_port_id
 * @property int|null $fund_id
 * @property float $present_value
 * @property float $cost_value
 * @property float $present_nav
 * @property float $cost_nav
 * @property float|null $units
 * @property float|null $profit
 * @property float|null $percent
 * @property float|null $ratio
 * @property float $realized
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Fund $fund
 * @property FundPort $fundPort
 * @property FundPortListDetail[] $fundPortListDetails
 * @property User $user
 */
class FundPortList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fund_port_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'fund_port_id', 'fund_id'], 'integer'],
            [['present_value', 'cost_value', 'present_nav', 'cost_nav', 'units', 'percent', 'ratio', 'profit', 'realized'], 'number'],
            [['created_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['fund_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fund::className(), 'targetAttribute' => ['fund_id' => 'id']],
            [['fund_port_id'], 'exist', 'skipOnError' => true, 'targetClass' => FundPort::className(), 'targetAttribute' => ['fund_port_id' => 'id']],
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
            'fund_port_id' => 'พอร์ต',
            'fund_id' => 'กองทุน',
            'present_value' => 'มูลค่าปัจจุบัน',
            'cost_value' => 'มูลค่าต้นทุน',
            'present_nav' => 'Nav ปัจจุบัน',
            'cost_nav' => 'Nav ต้นทุน',
            'units' => 'จำนวนหน่วย',
            'profit' => 'กำไร/ขาดทุน Unrealized',
            'realized' => 'กำไร/ขาดทุน Realized',
            'percent' => '%',
            'ratio' => 'สัดส่วน',
            'created_at' => 'สร้างเมื่อ',
            'updated_at' => 'อัพเดทเมื่อ',
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
     * Gets query for [[FundPort]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFundPort()
    {
        return $this->hasOne(FundPort::className(), ['id' => 'fund_port_id']);
    }

    /**
     * Gets query for [[FundPortListDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFundPortListDetails()
    {
        return $this->hasMany(FundPortListDetail::className(), ['fund_port_list_id' => 'id']);
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
