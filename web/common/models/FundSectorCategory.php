<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fund_sector_category".
 *
 * @property int $id
 * @property string $name_en
 * @property string|null $name_th
 * @property int $status
 */
class FundSectorCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fund_sector_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_en'], 'required'],
            [['status'], 'integer'],
            [['name_en', 'name_th'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_en' => 'Name En',
            'name_th' => 'Name Th',
            'status' => 'Status',
        ];
    }
}
