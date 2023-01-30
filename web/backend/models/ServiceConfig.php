<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "service_config".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string|null $setting
 * @property int $status
 */
class ServiceConfig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['setting'], 'safe'],
            [['status'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'setting' => 'Setting',
            'status' => 'Status',
        ];
    }
    
    public function getConfigByName($name) {
        $model = ServiceConfig::find()->where(['name' => $name])->one();
        if($model && $model->status){
            return true;
        }
        return false;
    }
    
    public function getDataConfigByName($name) {
        $model = ServiceConfig::find()->where(['name' => $name])->one();
        if($model && $model->status){
            return $model;
        }
        return false;
    }
    
    public function findSettingValue($setting, $name){
        foreach ($setting as $value) {
            if($value['name'] == $name){
                return $value['value'];
            }
        }
        return null;
    }
}
