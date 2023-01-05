<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use app\components\FundApi;
use common\models\AssetManagement;
use common\models\Fund;

/**
 * SystemServiceController implements the CRUD actions for SystemService model.
 */
class ServiceController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            /*'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],*/
        ];
    }
    
    public function actionGetAmc(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $api = new FundApi();
        $amc = $api->getAmc();
        
        $status = false;
        $data = 0;
        $save = 0;
        
        if($amc){
            foreach ($amc as $value) {
                $data += 1;
                
                $unique_id = $value['unique_id'];
                $name_th = $value['name_th'];
                $name_en = $value['name_en'];
                $last_upd_date = $value['last_upd_date'];
                
                $insert_amc = AssetManagement::find()->where(['amc_id' => $unique_id])->one();
                if(!$insert_amc){
                    $insert_amc = new AssetManagement();
                    $insert_amc->amc_id = $unique_id;
                }
                $insert_amc->name_th = $name_th;
                $insert_amc->name_en = $name_en;
                
                if($insert_amc->save()){
                    $save += 1;
                }
            }
        }
        
        return ['data' => $data, 'save' => $save];
    }

    
    public function actionGetFundNav()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $api = new FundApi();
        
        //$amc = $api->getAmc();
        //var_dump($amc);exit();
        $date = date('d/m/Y', strtotime("-2 days"));
        
        $api->start_date = $date;
        $api->end_date = $date;
        
        $fundData = $api->getFundNav();
        
        //echo '<pre>';
        //var_dump($data);exit();
        
        $data = 0;
        $save = 0;
        
        if($fundData && isset($fundData['fundNavs'])){
            $fundNav = $fundData['fundNavs'];
            echo '<pre>';
            var_dump($fundNav);exit();
            foreach ($fundNav as $value) {
                $data += 1;
                
                $amc_id = $value['amcId'];
                $fundConnextId = $value['fundConnextId'];
                $symbol = $value['symbol'];
                $nameTh = $value['nameTh'];
                $nameEn = $value['nameEn'];
                $nav = $value['nav'];
                $navPerUnit = $value['navPerUnit'];
                $priorNavPerUnit = $value['priorNavPerUnit'];
                $change = $value['change'];
                $navDate = $value['navDate'];
                $buySwapPrice = $value['buySwapPrice'];
                $sellSwapPrice = $value['sellSwapPrice'];
                $buyPrice = $value['buyPrice'];
                $sellPrice = $value['sellPrice'];
                $projectType = $value['projectType'];
                
                $amc = AssetManagement::find()->where(['amc_id' => $amc_id])->one();
                if(!$amc){
                    continue;
                }
                
                $fund = Fund::find()->where(['fund_connext_id' => $fundConnextId])->one();
                if(!$fund){
                    $fund = new Fund();
                    $fund->fund_connext_id = $fundConnextId;
                    $fund->amc_id = $amc_id;
                    $fund->asset_management_id = $amc->id;
                }
                $fund->symbol = $symbol;
                $fund->name_en = $nameTh;
                $fund->name_th = $nameEn;
                $fund->nav = $navPerUnit;
                $fund->nav_date = date('Y-m-d', strtotime($navDate));
                
                //$fund->fund_type_id = 0;
                //$fund->fund_type_in_id = 0;
                //$fund->dividend = 0;
                
                if($fund->save()){
                    $save += 1;
                }
                else{
                    var_dump($fund->errors);exit();
                }
            }
        }
        return ['data' => $data, 'save' => $save];
    }
}