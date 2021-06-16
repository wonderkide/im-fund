<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fund_port".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property float $amount
 * @property float $profit_amount
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property FundPortList[] $fundPortLists
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
            [['name', 'created_at'], 'required'],
            [['amount', 'profit_amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'ชื่อพอร์ต',
            'amount' => 'เงินทุน',
            'profit_amount' => 'กำไร/ขาดทุน',
            'created_at' => 'สร้างเมื่อ',
            'updated_at' => 'อัพเดทเมื่อ',
        ];
    }

    /**
     * Gets query for [[FundPortLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFundPortLists()
    {
        return $this->hasMany(FundPortList::className(), ['fund_port_id' => 'id']);
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
