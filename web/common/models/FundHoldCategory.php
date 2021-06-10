<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fund_hold_category".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $name_en
 * @property string|null $name_th
 * @property int $status
 *
 * @property User $user
 */
class FundHoldCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fund_hold_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            [['name_en'], 'required'],
            [['name_en', 'name_th'], 'string', 'max' => 255],
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
            'name_en' => 'Name En',
            'name_th' => 'Name Th',
            'status' => 'Status',
        ];
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
