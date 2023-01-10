<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "service_log".
 *
 * @property int $id
 * @property string $action
 * @property string|null $detail
 * @property string $created_at
 * @property int $status 1=success,0=erroe
 */
class ServiceLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['action', 'created_at'], 'required'],
            [['detail', 'created_at'], 'safe'],
            [['status'], 'integer'],
            [['action'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'action' => 'Action',
            'detail' => 'Detail',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
    
    public function insertLog($action, $status, $detail=null){
        $model = new ServiceLog();
        $model->action = $action;
        $model->detail = $detail;
        $model->created_at = date('Y-m-d H:i:s');
        $model->status = $status ? 1:0;
        
        if($model->save()){
            
        }
    }
}
