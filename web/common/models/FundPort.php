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
    
    public static function getTotal($provider, $fieldName)
    {
        $total = 0;

        foreach ($provider as $item) {
            $total += $item[$fieldName];
        }

        return $total;
    }
    
    public function getTotalTextNumber($provider, $fieldName, $text_before = null, $text_after = null)
    {
        $total = $this->getTotal($provider, $fieldName);
        $number = number_format($total, 2);
        $text = '<span class="text-bold text-dark">'.$text_before.$number.$text_after.'</span>';
        return $text;
    }
    
    public function getTotalTextColor($provider, $fieldName, $text_before = null, $text_after = null)
    {
        $total = $this->getTotal($provider, $fieldName);
        $number = number_format($total, 2);
        if($total > 0){
            $text = '<span class="text-bold text-success">'.$text_before.$number.$text_after.'</span>';
        }
        elseif($total < 0){
            $text = '<span class="text-bold text-danger">'.$text_before.$number.$text_after.'</span>';
        }
        else{
            $text = '<span class="text-bold text-dark">'.$text_before.$number.$text_after.'</span>';
        }
        return $text;
    }
    
    public function getTotalPercentTextColor($provider, $fieldCost, $fieldPresent, $text_before = null, $text_after = null)
    {
        $totalCost = $this->getTotal($provider, $fieldCost);
        $totalPresent = $this->getTotal($provider, $fieldPresent);
        
        if($totalCost == 0){
            return '<span class="text-bold text-dark">'.$text_before.'0'.$text_after.'</span>';
        }
        
        //$percent = $totalCost * ($totalPresent - $totalCost) / 100;
        
        $percent = ($totalPresent - $totalCost) * 100 / $totalCost;
        
        $number = number_format($percent, 2);
        if($percent > 0){
            $text = '<span class="text-bold text-success">'.$text_before.$number.$text_after.'</span>';
        }
        elseif($percent < 0){
            $text = '<span class="text-bold text-danger">'.$text_before.$number.$text_after.'</span>';
        }
        else{
            $text = '<span class="text-bold text-dark">'.$text_before.$number.$text_after.'</span>';
        }
        return $text;
    }
}
