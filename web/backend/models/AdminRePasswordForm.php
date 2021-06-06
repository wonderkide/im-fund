<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class AdminRePasswordForm extends Model
{
    public $password;
    public $re_password;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password', 're_password'], 'required', 'message' => 'กรุณากรอก{attribute}'],
            ['password', 'string', 'min' => 6, 'max' => 18, 'tooShort' => 'กรุณากรอก {attribute} อย่างน้อย 6 ตัว', 'tooLong' => 'กรุณากรอก {attribute} ไม่เกิน 18 ตัว'],
            ['re_password','compare','compareAttribute'=>'password', 'message' => 'กรุณากรอกรหัสผ่านใหม่ให้ตรงกับยืนยันรหัสผ่าน'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'รหัสผ่าน',
            're_password' => 'ยืนยันรหัสผ่าน',
        ];
    }
}
