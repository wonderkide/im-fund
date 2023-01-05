<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "asset_management".
 *
 * @property int $id
 * @property string $name_th
 * @property string $name_en
 * @property string|null $codename
 * @property string $amc_id
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
            [['name_th', 'name_en', 'amc_id'], 'required'],
            [['name_th', 'name_en', 'codename', 'amc_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amc_id' => 'amc_id',
            'name_th' => 'Name Th',
            'name_en' => 'Name En',
            'codename' => 'Code',
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
