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
            array_push($data['labels'], $value->fund->name);
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
}
