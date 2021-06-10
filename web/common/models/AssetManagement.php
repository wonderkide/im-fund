<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "asset_management".
 *
 * @property int $id
 * @property string $name_th
 * @property string|null $name_en
 * @property string|null $code
 *
 * @property Fund[] $funds
 */
class AssetManagement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asset_management';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_th'], 'required'],
            [['name_th', 'name_en', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_th' => 'Name Th',
            'name_en' => 'Name En',
            'code' => 'Code',
        ];
    }

    /**
     * Gets query for [[Funds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFunds()
    {
        return $this->hasMany(Fund::className(), ['asset_management_id' => 'id']);
    }
}
