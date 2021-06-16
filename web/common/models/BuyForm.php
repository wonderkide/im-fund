<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fund_port_list_detail".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $fund_port_list_id
 * @property string $date
 * @property float $nav
 * @property float $amount
 * @property float $units
 * @property string $created_at
 * @property int $type 1=ซื้อ,2=ขาย,3=สับเปลี่ยนเข้า,4=สับเปลี่ยนออก
 * @property int $status 1=ปกติ,0=ลบ
 *
 * @property FundPortList $fundPortList
 * @property User $user
 */
class BuyForm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fund_port_list_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'fund_port_list_id', 'type', 'status'], 'integer'],
            [['date', 'nav', 'amount', 'units', 'created_at', 'type'], 'required'],
            [['date', 'created_at'], 'safe'],
            [['nav', 'amount', 'units'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['fund_port_list_id'], 'exist', 'skipOnError' => true, 'targetClass' => FundPortList::className(), 'targetAttribute' => ['fund_port_list_id' => 'id']],
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
            'fund_port_list_id' => 'Fund Port List ID',
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
     * Gets query for [[FundPortList]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFundPortList()
    {
        return $this->hasOne(FundPortList::className(), ['id' => 'fund_port_list_id']);
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
