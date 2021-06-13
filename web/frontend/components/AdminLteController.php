<?php
 
namespace frontend\components;

use Yii;
use frontend\components\MyController;
 
class AdminLteController extends MyController {
    
    public function beforeAction($view) {
        
        $this->layout = '@app/themes/adminlte3/views/layouts/main';
        
        return parent::beforeAction($view);
    }

}
