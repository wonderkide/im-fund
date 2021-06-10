<?php
 
namespace frontend\components;

use Yii;
use yii\web\Controller;
//use app\components\Seo;
 
class MyController extends Controller {

    
    public function init() {
        //var_dump('seo');exit();
        //Seo::loadUrl();
        
        parent::init();
    }
    
    public function beforeAction($view) {
        
        $title = 'FUND MEMORIES';
        $description = 'ออกแบบ ทำรายงาน วิเคราห์และเปรียบเทียบ ข้อมูลการเงิน การลงทุน ตามสไตล์ตัวเองได้อย่างง่ายดาย';

        Yii::$app->view->title = $title;
        Yii::$app->view->registerMetaTag([
            'name' => 'title',
            'content' => $title
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $description
        ]);
        
        return parent::beforeAction($view);
    }
    
//    public function isLogin() {
//        if (\Yii::$app->user->isGuest){
//            return $this->redirect(Yii::$app->seo->getUrl('site/login'));
//        }
//    }
//    
//    public function checkPermission($id) {
//        if($id == Yii::$app->user->id){
//            return TRUE;
//        }
//        return FALSE;
//    }
//    
//    public function checkPermissionRank($detail_allow) {
//        $model = \app\models\RankModel::findOne(['detail'=>$detail_allow]);
//        if(Yii::$app->user->getIdentity()->permission != 1){
//            return true;
//        }
//        if($model && $model->exp <= Yii::$app->user->getIdentity()->exp){
//            return true;
//        }
//        return FALSE;
//    }
//    
//    public function checkBanned() {
//        if(Yii::$app->user->getIdentity()->status == \app\models\UserAuth::STATUS_DELETED){
//            return true;
//        }
//        return FALSE;
//    }
}
