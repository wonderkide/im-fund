<?php

namespace frontend\controllers;

use Yii;
use common\models\FundPort;
use common\models\FundPortSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use frontend\components\AdminLteController;
use yii\web\Response;
use yii\widgets\ActiveForm;
use common\models\FundPortList;
use common\models\FundPortListDetail;
use common\models\FundPortListSearch;
use common\models\FundPortListDetailSearch;
use common\models\BuyForm;
use yii\helpers\Url;
use common\models\Fund;
use yii\helpers\ArrayHelper;
use frontend\models\NoteForm;

/**
 * FundInvestController implements the CRUD actions for FundInvest model.
 */
class FundPortController extends AdminLteController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all FundInvest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FundPortSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FundInvest model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        //var_dump($id);exit();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FundInvest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FundPort();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->created_at = date('Y-m-d H:i:s');
            if($model->save()){
                Yii::$app->session->setFlash('success', 'อัพเดทข้อมูลสำเร็จ');
            }
            else{
                Yii::$app->session->setFlash('error', 'ไม่สามารถทำรายการได้');
            }
            Yii::$app->session->setFlash('success', 'อัพเดทข้อมูลสำเร็จ');
            return $this->redirect(['index']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FundInvest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'อัพเดทข้อมูลสำเร็จ');
            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing FundInvest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $port = $this->findModel($id);
            $port_list = FundPortList::find()->where(['port_id' => $id])->all();
            foreach ($port_list as $list) {
                $detail = FundPortListDetail::deleteAll(['fund_port_list_id' => $list->id]);
                $list->delete();
            }
            $port->delete();
            $transaction->commit();
                
            Yii::$app->session->setFlash('success', 'ทำรายการสำเร็จ');
            
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'มีบางอย่างผิดพลาด ไม่สามารถทำรายการได้');
            $transaction->rollBack();
        }
        return $this->redirect(['index']);
    }
    
    public function actionListDelete($id){
        $port_list = FundPortList::findOne($id);
        $redirect = ['fund-port/detail', 'id' => $port_list->fund_port_id];
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $detail = FundPortListDetail::deleteAll(['fund_port_list_id' => $port_list->id]);
            $port_list->delete();
            $transaction->commit();
                
            Yii::$app->session->setFlash('success', 'ทำรายการสำเร็จ');
            
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'มีบางอย่างผิดพลาด ไม่สามารถทำรายการได้');
            $transaction->rollBack();
        }
        return $this->redirect($redirect);
    }
    
    public function actionListDetailDelete($id){
        $detail = FundPortListDetail::findOne($id);
        $redirect = ['fund-port/list-detail', 'id' => $detail->fund_port_list_id];
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $detail->delete();
            $transaction->commit();
                
            Yii::$app->session->setFlash('success', 'ทำรายการสำเร็จ');
            
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'มีบางอย่างผิดพลาด ไม่สามารถทำรายการได้');
            $transaction->rollBack();
        }
        return $this->redirect($redirect);
    }

    /**
     * Finds the FundInvest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FundInvest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FundPort::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionDetail($id){
        $port = $this->findModel($id);
        if(!$port){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $list = FundPortList::find()->where(['fund_port_id' => $id])->orderBy(['percent' => SORT_DESC])->all();
        
        $searchModel = new FundPortListSearch();
        $searchModel->fund_port_id = $id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        
        
        return $this->render('detail',[
            'port' => $port,
            'list' => $list,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionBuy($id){
        
        $redirect = Url::to(['detail', 'id' => $id]);
        
        $port = $this->findModel($id);
        if(!$port){
            Yii::$app->session->setFlash('error', 'ไม่พบข้อมูลพอร์ตที่ท่านเลือก');
            return $this->redirect($redirect);
        }
        
        $model = new BuyForm();
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $user_id = \Yii::$app->user->id;
                $port_list = FundPortList::find()->where(['user_id' => $user_id, 'fund_port_id' => $port->id, 'fund_id' => $model->fund_id])->one();
                if(!$port_list){
                    $port_list = new FundPortList();
                    $port_list->user_id = $user_id;
                    $port_list->fund_port_id = $port->id;
                    $port_list->fund_id = $model->fund_id;
                    $port_list->created_at = date('Y-m-d H:i:s');
                    $port_list->save();
                }
                $unit = $model->amount / $model->nav;
                $unit = Fund::setDecimal4Digit($unit);
                $model->user_id = $user_id;
                $model->fund_port_list_id = $port_list->id;
                $model->units = $unit;
                $model->created_at = date('Y-m-d H:i:s');
                $model->type = 1;
                $model->status = 1;
                
                $fund = Fund::findOne($model->fund_id);
                if($fund->fund_type_in_id == 4){
                    //$date_totime = strtotime($model->date);
                    //$Y = date('Y', $date_totime);
                    //$futureY = ((int)$Y)+10;
                    $sale_date = date('Y-m-d', strtotime($model->date. ' + 10 years'));
                    $model->sale_date = $sale_date;
                }
                $model->save();
                
                $transaction->commit();
                
                Yii::$app->session->setFlash('success', 'ทำรายการสำเร็จ');
                return $this->redirect($redirect);
                
            } catch (\Exception $e) {
                var_dump($e);exit();
                Yii::$app->session->setFlash('error', 'มีบางอย่างผิดพลาด ไม่สามารถทำรายการได้');
                $transaction->rollBack();
                return $this->redirect($redirect);
            }
        }

        return $this->renderAjax('_buy', [
            'model' => $model,
        ]);
    }
    
    public function actionListDetail($id){
        $port_list = FundPortList::findOne($id);
        if(!$port_list){
            Yii::$app->session->setFlash('error', 'ไม่พบข้อมูลที่ท่านเลือก');
            return $this->redirect(['index']);
        }
        
        $searchModel = new FundPortListDetailSearch();
        $searchModel->fund_port_list_id = $id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        
        return $this->render('list-detail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'port_list' => $port_list
        ]);
    }
    
    public function actionListBuy($id){
        //var_dump(1);exit();
        
        $port_list = FundPortList::findOne($id);
        if(!$port_list){
            Yii::$app->session->setFlash('error', 'ไม่พบข้อมูลพอร์ตที่ท่านเลือก');
            return $this->redirect(['index']);
        }
        
        $redirect = Url::to(['detail', 'id' => $port_list->fund_port_id]);
        
        $model = new BuyForm();
        $model->fund_id = $port_list->fund_id;
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $user_id = \Yii::$app->user->id;
                //$port_list = FundPortList::find()->where(['user_id' => $user_id, 'fund_port_id' => $port->id, 'fund_id' => $model->fund_id])->one();

                $unit = $model->amount / $model->nav;
                $unit = Fund::setDecimal4Digit($unit);
                $model->user_id = $user_id;
                $model->fund_port_list_id = $port_list->id;
                $model->units = $unit;
                $model->created_at = date('Y-m-d H:i:s');
                $model->type = 1;
                $model->status = 1;
                $model->save();
                
                $fund = Fund::findOne($model->fund_id);
                if($fund->fund_type_in_id == 4){
                    $sale_date = date('Y-m-d', strtotime($model->date. ' + 10 years'));
                    $model->sale_date = $sale_date;
                }
                
                $transaction->commit();
                
                Yii::$app->session->setFlash('success', 'ทำรายการสำเร็จ');
                return $this->redirect($redirect);
                
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', 'มีบางอย่างผิดพลาด ไม่สามารถทำรายการได้');
                $transaction->rollBack();
                return $this->redirect($redirect);
            }
        }

        return $this->renderAjax('_buy', [
            'model' => $model,
        ]);
    }
    
    public function actionListSell($id){
        
        $port_list = FundPortList::findOne($id);
        if(!$port_list){
            Yii::$app->session->setFlash('error', 'ไม่พบข้อมูลพอร์ตที่ท่านเลือก');
            return $this->redirect(['index']);
        }
        
        $redirect = Url::to(['detail', 'id' => $port_list->fund_port_id]);
        
        $model = new BuyForm();
        $model->fund_id = $id;
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $user_id = \Yii::$app->user->id;
                //$port_list = FundPortList::find()->where(['user_id' => $user_id, 'fund_port_id' => $port->id, 'fund_id' => $model->fund_id])->one();

                $unit = $model->amount / $model->nav;
                $unit = Fund::setDecimal4Digit($unit);
                $model->user_id = $user_id;
                $model->fund_port_list_id = $port_list->id;
                $model->units = $unit;
                $model->created_at = date('Y-m-d H:i:s');
                $model->type = 2;
                $model->status = 1;
                $model->save();
                
                $transaction->commit();
                
                Yii::$app->session->setFlash('success', 'ทำรายการสำเร็จ');
                return $this->redirect($redirect);
                
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', 'มีบางอย่างผิดพลาด ไม่สามารถทำรายการได้');
                $transaction->rollBack();
                return $this->redirect($redirect);
            }
        }

        return $this->renderAjax('_buy', [
            'model' => $model,
        ]);
    }
    
    public function actionCalculator($id){
        $port = $this->findModel($id);
        $redirect = Url::to(['detail', 'id' => $id]);
        if(!$port){
            Yii::$app->session->setFlash('error', 'ไม่พบข้อมูลพอร์ตที่ท่านเลือก');
            return $this->redirect($redirect);
        }
        
        $port_list = FundPortList::find()->where(['fund_port_id' => $id])->all();
        if(!$port_list){
            Yii::$app->session->setFlash('error', 'ยังไม่มีข้อมูลกองทุน');
            return $this->redirect($redirect);
        }
        foreach ($port_list as $list) {
            //$count_list_detail = FundPortListDetail::find()->where(['fund_port_list_id' => $list->id])->count();
            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("
                SELECT SUM(nav) AS nav, SUM(amount) AS amount, SUM(units) AS units, COUNT(id) AS count_list
                FROM fund_port_list_detail
                WHERE fund_port_list_id = $list->id AND type = 1 AND status = 1
                GROUP BY fund_port_list_id
                ");
            $sum = $command->queryOne();
            //var_dump($sum);exit();
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
            WHERE fund_port_id = $id 
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
        
        Yii::$app->session->setFlash('success', $port->name . ' update success');
        return $this->redirect([$redirect]);
    }
    
    public function actionChart($id){
        $port = $this->findModel($id);
        $redirect = Url::to(['detail', 'id' => $id]);
        if(!$port){
            Yii::$app->session->setFlash('error', 'ไม่พบข้อมูลพอร์ตที่ท่านเลือก');
            return $this->redirect($redirect);
        }
        
        $data = $this->setChartData($port);
        
        return $this->render('chart', [
            'port' => $port,
            'data' => $data
        ]);
    }
    
    public function actionHistory($id){
        
        $port = $this->findModel($id);
        $redirect = Url::to(['detail', 'id' => $id]);
        if(!$port){
            Yii::$app->session->setFlash('error', 'ไม่พบข้อมูลพอร์ตที่ท่านเลือก');
            return $this->redirect($redirect);
        }
        
        $port_list = FundPortList::find()->where(['fund_port_id' => $id])->all();
        $port_list_id_all = ArrayHelper::getColumn($port_list, 'id');
        
        //var_dump($port_list_id_all);exit();
        
        /*$connection = Yii::$app->getDb();
        $command = $connection->createCommand("
            SELECT SUM(amount) AS amount, date
            FROM fund_port_list_detail
            WHERE fund_port_list_id = 1
            GROUP BY date
            ORDER BY date desc");

        $result = $command->queryAll();*/
        
        //$detail_d = FundPortListDetail::find()->select('SUM(amount) AS amount, date')->where(['fund_port_list_id' => $port_list_id_all])->orderBy(['date' => SORT_DESC])->groupBy('DATE(date)')->all();
        //$detail_m = FundPortListDetail::find()->select('SUM(amount) AS amount, date')->where(['fund_port_list_id' => $port_list_id_all])->orderBy(['date' => SORT_DESC])->groupBy('MONTH(date)')->all();
        //$detail_y = FundPortListDetail::find()->select('SUM(amount) AS amount, date')->where(['fund_port_list_id' => $port_list_id_all])->orderBy(['date' => SORT_DESC])->groupBy('YEAR(date)')->all();
        
        //$detail_all = FundPortListDetail::find()->where(['fund_port_list_id' => $port_list_id_all])->orderBy(['date' => SORT_DESC])->all();
        
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
            SELECT fund_port_list_detail.*
             , fund.symbol
            FROM fund_port_list_detail, fund_port_list, fund
            WHERE fund_port_list_detail.fund_port_list_id = fund_port_list.id AND fund_port_list.fund_id = fund.id
            
            ORDER BY fund_port_list_detail.date desc");

        $result = $command->queryAll();
        
        $data = $this->sumHistoryData($result);

        //var_dump($data['m']);exit();
        
        /*$connection = Yii::$app->getDb();
        $command = $connection->createCommand("
            SELECT fund_port_list_detail.*
             , fund.symbol
            FROM fund_port_list_detail, fund_port_list, fund
            WHERE fund_port_list_detail.fund_port_list_id = fund_port_list.id AND fund_port_list.fund_id = fund.id
            
            ORDER BY fund_port_list_detail.date desc");

        $result = $command->queryAll();*/
        
        
        return $this->render('history', [
            'port' => $port,
            'port_list' => $port_list,
            'history' => $data
        ]);
    }
    
    public function actionGetHistory(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $id = Yii::$app->request->get('id');
        $date= Yii::$app->request->get('date');
        
        $port = $this->findModel($id);
        if(!$port){
            return ['status' => false, 'data' => ''];
        }
        
        $port_list = FundPortList::find()->where(['fund_port_id' => $id])->all();
        $port_list_id_all = ArrayHelper::getColumn($port_list, 'id');
        
        $arr = implode("','",$port_list_id_all);
        //return $arr;
        
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
            SELECT fund_port_list_detail.*
             , fund.symbol
            FROM fund_port_list_detail, fund_port_list, fund
            WHERE fund_port_list_detail.fund_port_list_id = fund_port_list.id AND fund_port_list.fund_id = fund.id
            AND fund_port_list_id IN ('$arr') AND date = '$date'
            ORDER BY fund_port_list_detail.date desc");

        $history = $command->queryAll();
        
        $text = $this->renderAjax('_history_table', [
            'history' => $history
        ]);
        
        return ['status' => true, 'data' => $text];
    }
    
    public function actionViewListDetail($id){
        $list = FundPortListDetail::findOne($id);
        
        return $this->renderAjax('view-list-detail',[
            'model' => $list
        ]);
    }
    
    public function actionNoteListDetail($id){
        $list = FundPortListDetail::findOne($id);
        
        $model = new NoteForm();
        $model->note = $list->note;
        
        $redirect = Url::to(['list-detail', 'id' => $list->fund_port_list_id]);
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $list->note = $model->note;
            if($list->save()){
                Yii::$app->session->setFlash('success', 'บันทึกข้อมูลสำเร็จ');
                return $this->redirect($redirect);
            }
            else{
                Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกได้');
                return $this->redirect($redirect);
            }
        }
        
        return $this->renderAjax('note-list-detail',[
            'model' => $model
        ]);
    }
    
    protected function setChartData($port) {
        $port_list = FundPortList::find()->where(['fund_port_id' => $port->id])->all();
        $data = [];
        $data['labels'] = [];
        $data['datasets'] = [];
        $data['datasets'][0] = [];
        $data['datasets'][0]['data'] = [];
        $data['datasets'][0]['backgroundColor'] = [];
        
        $key = 0;
        foreach ($port_list as $value) {
            $set = $value->ratio ? $value->ratio:$value->present_value;
            $color = $this->getColor($key);
            array_push($data['labels'], $value->fund->symbol);
            array_push($data['datasets'][0]['data'], $set);
            array_push($data['datasets'][0]['backgroundColor'], $color);
            //$data['labels'] = $value->fund->name;
            $key++;
        }
        return $data;
    }
    
    protected function getColor($index) {
        //$arr = ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'];
        
        $arr = ['#003f5c', '#2f4b7c', '#665191', '#a05195', '#d45087', '#f95d6a', '#ff7c43', '#ffa600'];
        //$arr = [];
        if(isset($arr[$index])){
            return $arr[$index];
        }
        else{
            $min = 0;
            $max = 255;
            $r = rand($min,$max);
            $g = rand($min,$max);
            $b = rand($min,$max);
            
            return "rgba($r, $g, $b, 1)";
        }
        
        $backgroundColor = [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)'
        ];
        $borderColor = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
        ];
        
        return $backgroundColor[$index];
    }
    
    public function sumHistoryData($data){
        $detail_d = $detail_m = $detail_y = [];
        
        $d = $m = $y = null;
        foreach ($data as $value) {
            $totime = strtotime($value['date']);
            $d_i = $value['date'];
            $m_i = date('Y-m', $totime);
            $y_i = date('Y', $totime);
            
            if($d != $d_i){
                $detail_d[$d_i] = [];
                $detail_d[$d_i]['data'] = [];
                $detail_d[$d_i]['date'] = $d_i;
                $detail_d[$d_i]['amount'] = 0;
            }
            if($m != $m_i){
                $detail_m[$m_i] = [];
                $detail_m[$m_i]['data'] = [];
                $detail_m[$m_i]['date'] = $m_i;
                $detail_m[$m_i]['amount'] = 0;
            }
            if($y != $y_i){
                $detail_y[$y_i] = [];
                $detail_y[$y_i]['data'] = [];
                $detail_y[$y_i]['date'] = $y_i;
                $detail_y[$y_i]['amount'] = 0;
            }
            
            $detail_d[$d_i]['amount'] += $value['amount'];
            $detail_m[$m_i]['amount'] += $value['amount'];
            $detail_y[$y_i]['amount'] += $value['amount'];
            
            array_push($detail_d[$d_i]['data'], $value);
            array_push($detail_m[$m_i]['data'], $value);
            array_push($detail_y[$y_i]['data'], $value);
            
            $d = $d_i;
            $m = $m_i;
            $y = $y_i;
        }
        
        return ['d' => $detail_d, 'm' => $detail_m, 'y' => $detail_y];
    }
}
