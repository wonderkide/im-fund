<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fund_type_in".
 *
 * @property int $id
 * @property string $name
 *
 * @property Fund[] $funds
 */
class FundTypeIn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fund_type_in';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Funds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFunds()
    {
        return $this->hasMany(Fund::className(), ['fund_type_in_id' => 'id']);
    }
}
