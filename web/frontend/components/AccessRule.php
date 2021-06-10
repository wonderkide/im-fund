<?php
 
namespace app\components;
 
use app\models\UserAuth;
class AccessRule extends \yii\filters\AccessRule {
 
    /**
     * @inheritdoc
     */
    protected function matchRole($user)
    {        
        if (!$user->identity) {
            return false;
        }
        foreach ($this->roles as $role) {
            If($role == $user->identity->permission){
                return true;
            }

        }
        
 
        return false;
    }
}