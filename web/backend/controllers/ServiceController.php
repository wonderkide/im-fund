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
            if($model->validate() && Yii::$app->request->post('valid')){
                
                return $this->getFundNav($model->date);
            }
            return ActiveForm::validate($model);
        }
        
        return $this->renderAjax('get-nav-form',[
            'model' => $model
        ]);
    }
    
    public function actionGetAmc(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $api = new FundApi();
        $amc = $api->getAmc();
        
        $status = false;
        
        $data = 0;
        $save = 0;
        $error = null;
        $alert_msg = null;
        
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
        
        return ['status' => $status, 'data' => $data, 'save' => $save, 'message' => $alert_msg, 'url' => Url::to(['index'])];
    }

    
    public function actionGetFundNav()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $d = date('D');
        if($d == 'Mon'){
            $date = date('d/m/Y', strtotime("-3 days"));
        }
        else{
            $date = date('d/m/Y', strtotime("-1 days"));
        }
        //$date = '03/01/2023';
        
        return $this->getFundNav($date);
    }
    
    public function actionCalculateNav(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $ports = FundPort::find()->all();
        
        $all = 0;
        $success = 0;
        $error = 0;
        $message = '';
        $err_ms = [];
        
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
        $err = [];
        $alert_msg = null;
        
        if($fundData && isset($fundData['fundNavs'])){
            
            $fundNav = $fundData['fundNavs'];
            //echo '<pre>';
            //var_dump($fundNav);exit();
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
                
                $pos = strpos($symbol, 'SSF');
                if ($pos !== false) {
                    $fund->fund_type_in_id = 4;
                    //var_dump('555');exit();
                }
                else{
                    $fund->fund_type_in_id = 1;
                }
                
                //$fund->fund_type_id = 0;
                //$fund->fund_type_in_id = 0;
                //$fund->dividend = 0;
                
                if($fund->save()){
                    $save += 1;
                }
                else{
                    array_push($fund->errors);
                    //$err = $fund->errors;
                    //var_dump($err);exit();
                }
            }
            $status = true;
            $alert_msg = 'สำเร็จ';
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
        $status = false;
        $message = '';
        
        $transaction = Yii::$app->db->beginTransaction();
        try {
        
            $port_list = FundPortList::find()->where(['fund_port_id' => $port->id])->all();
            foreach ($port_list as $list) {
                $connection = Yii::$app->getDb();
                $command = $connection->createCommand("
                    SELECT SUM(nav) AS nav, SUM(amount) AS amount, SUM(units) AS units, COUNT(id) AS count_list
                    FROM fund_port_list_detail
                    WHERE fund_port_list_id = $list->id AND type = 1 AND status = 1
                    GROUP BY fund_port_list_id
                    ");
                $sum = $command->queryOne();

                $cost_nav = $sum['nav'] / $sum['count_list'];
                $cost_nav = Fund::setDecimal4Digit($cost_nav);
                $amount = $sum['amount'];
                $units = $sum['units'];

                $cost_value = $amount;

                $fund = Fund::findOne($list->fund_id);
                $present_nav = $fund->nav;
                $present_value = $present_nav * $units;
                $present_value = Fund::setDecimal4Digit($present_value);

                $percent = round((($present_value*100/$cost_value)-100), 2);

                $list->present_value = $present_value;
                $list->cost_value = $cost_value;
                $list->present_nav = $present_nav;
                $list->cost_nav = $cost_nav;
                $list->units = $units;
                $list->profit = $present_value-$cost_value;
                $list->percent = $percent;
                $list->updated_at = date('Y-m-d H:i:s');
                $list->save();

                //var_dump($sum);exit();
            }

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("
                SELECT SUM(present_value) AS present_value, SUM(cost_value) AS cost_value
                FROM fund_port_list
                WHERE fund_port_id = $port->id 
                ");
            $sum = $command->queryOne();

            $sum_cost = $sum['cost_value'];
            $sum_present = $sum['present_value'];
            $port->amount = $sum_cost;
            $port->profit_amount = $sum_present-$sum_cost;
            $port->updated_at = date('Y-m-d H:i:s');
            $port->save();
            foreach ($port_list as $list) {
                $avg = $list->present_value * 100 / $sum_present;
                $list->ratio = $avg;
                $list->save();
            }
            $status = true;
            $transaction->commit();
            
        } catch (\Exception $e) {
            $message = $e;
            $transaction->rollBack();
        }
        
        return ['status' => $status, 'port_id' => $port->id, 'message' => $message];
    }
}