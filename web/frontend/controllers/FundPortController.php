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
use common\models\BuyForm;

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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
    
    public function actionBuy(){
        
        $model = new BuyForm();
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $port_list = FundPortList::find()->where($condition);
            Yii::$app->session->setFlash('success', 'อัพเดทข้อมูลสำเร็จ');
            return $this->redirect(['index']);
        }

        return $this->renderAjax('_buy', [
            'model' => $model,
        ]);
    }
}
