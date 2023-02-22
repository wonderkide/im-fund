<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use app\components\FundApi;
use common\models\AssetManagement;
use common\models\Fund;
use backend\models\ServiceLog;
use yii\helpers\Url;
use common\models\FundPort;
use common\models\FundPortList;
use common\models\FundPortListDetail;
use backend\models\DateForm;
use backend\models\ServiceConfig;
use yii\helpers\ArrayHelper;
use common\components\CalculateService;


use yii\web\Response;
use yii\widgets\ActiveForm;

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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'get-nav-form'],
                'rules' => [
                    [
                        'actions' => ['index', 'get-nav-form'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex(){
        return $this->render('index');
    }
    
    public function actionGetNavForm(){
        
        $model = new DateForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            //return json_decode('{"status":true,"data":2262,"save":2260,"error":null,"message":"สำเร็จ","url":"/service/index"}');
            if($model->validate() && Yii::$app->request->post('valid')){
                //$kk = ["status"=>true, "data" => 2262, "save" => 2260, "error" => NULL, "message" => "สำเร็จ", "url" => "/service/index"];
                //var_dump($kk);exit();
                //return $kk;

                //return json_decode('{"status":true,"data":2262,"save":2260,"error":null,"message":"สำเร็จ","url":"/service/index"}');
                $res = $this->getFundNav($model->date);
                
                //return $res;
                
                if($res['status']){
                    Yii::$app->session->setFlash('success', $res['message']);
                    return $this->redirect(['index']);
                }
                else{
                    Yii::$app->session->setFlash('error', $res['message']);
                    return $this->redirect(['index']);
                }
            }
            return ActiveForm::validate($model);
        }
        
        return $this->renderAjax('get-nav-form',[
            'model' => $model
        ]);
    }
    
    public function actionGetAmc(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $service_config = new ServiceConfig();
        $config = $service_config->getConfigByName('get_amc');
        
        $status = false;
        
        $data = 0;
        $save = 0;
        $error = null;
        $alert_msg = null;
        
        if($config){
            $api = new FundApi();
            $amc = $api->getAmc();



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
                $status = true;
                $alert_msg = 'สำเร็จ';

            }
            else{
                $error = 'cannot get amc';
                $alert_msg = 'ไม่สามารถดึงข้อมูลได้';
            }

            $message = ['data' => $data, 'save' => $save , 'error' => $error];

            $action = 'get-amc';
            $log = new ServiceLog();
            $log->insertLog($action, $status, $message);
        }
        else{
            $error = 'service ปิดอยู่';
            $alert_msg = 'service ปิดอยู่';
        }
        
        return ['status' => $status, 'data' => $data, 'save' => $save, 'message' => $alert_msg, 'url' => Url::to(['index'])];
    }

    
    public function actionGetFundNav()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $service_config = new ServiceConfig();
        $config = $service_config->getDataConfigByName('get_fund_nav');
        
        if($config && $config->status){
            
            
            $before = 1;
            if($config->setting){
                $get_before = $service_config->findSettingValue($config->setting, 'before');
                if($get_before){
                    $before = (int)$get_before;
                }
            }
            
            $d = date('D', strtotime("-$before days"));
            if($d == 'Sun' || $d == 'Sat'){
                $before += 2;
            }
            $date = date('d/m/Y', strtotime("-$before days"));

            /*$d = date('D');
            if($d == 'Mon'){
                $date = date('d/m/Y', strtotime("-3 days"));
            }
            else{
                $date = date('d/m/Y', strtotime("-1 days"));
            }*/
            
            return $this->getFundNav($date);
        }
        else{
            return ['status' => false, 'message' => 'service ปิดอยู่'];
        }
    }
    
    public function actionCalculateNav(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $ports = FundPort::find()->all();
        
        $all = 0;
        $success = 0;
        $error = 0;
        $message = '';
        $err_ms = [];
        
        $service_config = new ServiceConfig();
        $config = $service_config->getConfigByName('calculate_port');
        
        if($config){
            if($ports){
                $all = count($ports);
                foreach ($ports as $port) {
                    $cal_stat = $this->calculatorPort($port);
                    if($cal_stat['status']){
                        $success += 1;
                    }
                    else{
                        $error += 1;
                        array_push($err_ms, $cal_stat['message']);
                    }
                }
                $message = 'all : ' . $all . ', success : ' .$success . ', error : '. $error;

            }
            else{
                $message = 'ไม่มีข้อมูล port';
            }

            $action = 'calculate-nav';
            $l_m = [];
            $l_m['message'] = $message;
            $l_m['err'] = $err_ms;
            $log = new ServiceLog();
            $log->insertLog($action, true, $l_m);
        }
        else{
            $message = 'service ปิดอยู่';
            return ['status' => false, 'all' => $all, 'success' => $success, 'error' => $error, 'message' => $message, 'url' => Url::to(['index'])];
        }
        
        return ['status' => true, 'all' => $all, 'success' => $success, 'error' => $error, 'message' => $message, 'url' => Url::to(['index'])];
    }
    
    public function actionCalculateNavAll(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $ports = FundPort::find()->all();
        
        $all = 0;
        $success = 0;
        $error = 0;
        $message = '';
        $err_ms = [];
        
        $service_config = new ServiceConfig();
        $config = $service_config->getConfigByName('calculate_port');
        
        if($config){
            if($ports){
                $all = count($ports);
                foreach ($ports as $port) {
                    $cal_stat = $this->calculatorPortAll($port);
                    if($cal_stat['status']){
                        $success += 1;
                    }
                    else{
                        $error += 1;
                        array_push($err_ms, $cal_stat['message']);
                    }
                }
                $message = 'all : ' . $all . ', success : ' .$success . ', error : '. $error;

            }
            else{
                $message = 'ไม่มีข้อมูล port';
            }

            $action = 'calculate-nav';
            $l_m = [];
            $l_m['message'] = $message;
            $l_m['err'] = $err_ms;
            $log = new ServiceLog();
            $log->insertLog($action, true, $l_m);
        }
        else{
            $message = 'service ปิดอยู่';
            return ['status' => false, 'all' => $all, 'success' => $success, 'error' => $error, 'message' => $message, 'url' => Url::to(['index'])];
        }
        
        return ['status' => true, 'all' => $all, 'success' => $success, 'error' => $error, 'message' => $message, 'url' => Url::to(['index'])];
    }
    
    private function getFundNav($date){
        $api = new FundApi();
        
        $api->start_date = $date;
        $api->end_date = $date;
        
        $fundData = $api->getFundNav();
        
        //echo '<pre>';
        //var_dump($fundData);exit();
        
        $status = false;
        $data = 0;
        $save = 0;
        $err = null;
        $alert_msg = null;
        
        if($fundData && isset($fundData['fundNavs'])){
            
            $fundNav = $fundData['fundNavs'];
            //echo '<pre>';
            //var_dump($fundNav);exit();
            
            $check_db = Yii::$app->db->beginTransaction();
            try {
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

                        $pos = strpos($symbol, 'SSF');
                        if ($pos !== false) {
                            $fund->fund_type_in_id = 4;
                        }
                        else{
                            $fund->fund_type_in_id = 1;
                        }
                    }
                    $fund->symbol = $symbol;
                    $fund->name_en = $nameEn;
                    $fund->name_th = $nameTh;
                    $fund->nav = $navPerUnit;
                    $fund->nav_date = date('Y-m-d', strtotime($navDate));



                    //$fund->fund_type_id = 0;
                    //$fund->fund_type_in_id = 0;
                    //$fund->dividend = 0;

                    if($fund->save()){
                        $save += 1;
                    }
                    else{
                        //array_push($fund->errors);
                        //$err = $fund->errors;
                        //var_dump($err);exit();
                    }
                }
                
                $status = true;
                $alert_msg = 'สำเร็จ';
                
                $check_db->commit();
                
            } catch (\Exception $e) {
                $check_db->rollBack();
                
                $alert_msg = 'มีบางอย่างผิดพลาด';
                $err = $e;
            }
        }
        else{
            $alert_msg = 'ไม่สามารถดึงข้อมูลได้';
        }
        
        $message = ['data' => $data, 'save' => $save, 'error' => $err];
        
        $action = 'get-fund-nav';
        $log = new ServiceLog();
        $log->insertLog($action, $status, $message);
        
        return ['status' => $status, 'data' => $data, 'save' => $save, 'error' => $err, 'message' => $alert_msg, 'url' => Url::to(['index'])];
    }
    
    private function calculatorPort($port){
        $service = new CalculateService();
        
        $res = $service->calculatePortAll($port);
        
        return ['status' => $res['status'], 'port_id' => $port->id, 'message' => $res['message']];
    }


    private function calculatorPortAll($port){
        $service = new CalculateService();
        
        $res = $service->calculatePortAll($port, true);
        
        return ['status' => $res['status'], 'port_id' => $port->id, 'message' => $res['message']];
    }
}