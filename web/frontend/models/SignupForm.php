<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $fullname;
    public $password;
    public $re_password;
    public $verifyCode;
    
    public $agree_rule;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message' => 'กรุณากรอก {attribute}'],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i', 'message' => 'ห้ามใช้อักขระพิเศษ และมีช่องว่าง ท่านสามารถใช้ a-z และ 0-9 ได้เท่านั้น'],
            //['username', 'unique'],
            ['username', 'unique', 'targetClass' => 'common\models\User', 'message' => 'Username นี้ถูกใช้ไปแล้ว'],
            ['username', 'string', 'min' => 6, 'max' => 14],

            //['email', 'filter', 'filter' => 'trim'],
            //['email', 'required', 'message' => 'กรุณากรอก {attribute}'],
            //['email', 'email', 'message' => 'กรุณากรอกรูปแบบ {attribute} ให้ถูกต้อง'],
            //['email', 'string', 'max' => 255],
            //['email', 'unique', 'targetClass' => 'common\models\User', 'message' => 'Email นี้ถูกใช้ไปแล้ว'],

            ['password', 'required', 'message' => 'กรุณากรอก {attribute}'],
            ['password', 'string', 'min' => 8, 'max' => 18],
            
            ['re_password', 'required', 'message' => 'กรุณากรอก {attribute}'],
            ['re_password','compare','compareAttribute'=>'password', 'message' => 'กรุณากรอก {attribute} ให้ตรงกับ รหัสผ่าน'],
            
            //['verifyCode', 'captcha'],
            
            //['username', 'allowUser'],
            
            ['agree_rule', 'required', 'message' => 'ท่านต้องยอมรับเงื่อนไขการใช้งาน'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username' => 'ชื่อผู้ใช้',
            'password' => 'รหัสผ่าน',
            'email' => 'อีเมล์',
            're_password' => 'ยืนยันรหัสผ่าน',
            'verifyCode' => 'Verification Code',
        ];
    }
    
    /*public function allowUser($attribute, $params) {
        $model = MainDataModel::find()->where(['type'=>'allowuser'])->one();
        $not = explode(',', $model->content);
        foreach ($not as $value) {
            if(is_numeric(strpos($this->$attribute, $value))){
                $this->addError($attribute, 'คุณไม่สามารถใช้งาน Username ชื่อนี้ได้.');
            }
            
        }
    }*/

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        //$user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        //$user->generateEmailVerificationToken();
        
        $user->username = $this->username;
        //$user->email = $this->email;
        //$user->phone = $this->phone;
        $user->created_at = date('Y-m-d H:i:s');
        $user->ip = Yii::$app->request->getUserIP();
        $user->status = 1;

        if ($user->save()) {
            return $user;
        }
        return null;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
