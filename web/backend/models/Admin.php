<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property int $id
 * @property string $username
 * @property string|null $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property int|null $role 1=user,5=superuser,10=admin
 * @property int|null $status 0=inactive,1=active
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Admin extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const ROLE_ADMIN = 10;
    const ROLE_SUPERADMIN = 5;
    const ROLE_USER = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'admin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [
                    self::STATUS_ACTIVE, self::STATUS_INACTIVE
                ]],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => [
                    self::ROLE_ADMIN, self::ROLE_SUPERADMIN, self::ROLE_USER
                ]],
            [['username', 'password_hash'], 'required'],
            [['role', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username'], 'string', 'max' => 25],
            [['auth_key', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['username'], 'username_not_allow'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'role' => 'Role',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function username_not_allow($attribute, $params){
        if($this->username == 'system'){
            $this->addError('username', 'Username ' . $this->username . ' is not allow.');
        }
    }

    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function getAuthKey(): string {
        return $this->auth_key;
    }

    public function getId() {
        return $this->getPrimaryKey();
    }

    public function validateAuthKey($authKey): bool {
        return $this->auth_key === $authKey;
    }

    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        
    }
    
    public function getRoles($id = null){
        $role = [1 => 'User', 5 => 'Super admin', 10 => 'Admin'];
        if($id){
            return isset($role[$id]) ? $role[$id]:null;
        }
        return $role;
    }
    
    public function getRoleModify(){
        $admin_role = Yii::$app->user->identity->role;
        if($admin_role == 10){
            $role = [1 => 'User', 5 => 'Super admin', 10 => 'Admin'];
        }
        elseif($admin_role == 5){
            $role = [1 => 'User', 5 => 'Super admin'];
        }
        else{
            $role = [1 => 'User'];
        }
        return $role;
    }

}
