<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fund_type".
 *
 * @property int $id
 * @property string $name
 * @property string|null $name_en
 * @property int|null $parent_id
 *
 * @property Fund[] $funds
 */
class FundType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fund_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['name', 'name_en'], 'string', 'max' => 255],
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
            'name_en' => 'Name En',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * Gets query for [[Funds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFunds()
    {
        return $this->hasMany(Fund::className(), ['fund_type_id' => 'id']);
    }
}
