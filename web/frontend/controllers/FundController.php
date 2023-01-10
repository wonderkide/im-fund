<?php

namespace frontend\controllers;

use common\models\Fund;
use common\models\FundSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use frontend\components\AdminLteController;
use yii\web\Response;
use yii\widgets\ActiveForm;
use Yii;
use yii\db\Query;
//use common\components\FinnominaService;

/**
 * FundController implements the CRUD actions for Fund model.
 */
class FundController extends AdminLteController
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
    
    public function beforeAction($action)
    {
        $this->layout = '@app/themes/adminlte3/views/layouts/main';
        return parent::beforeAction($action);
    }
    
    public function actionIndex()
    {

        return $this->render('main', [
            
        ]);
    }
    
    public function actionFundList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, symbol AS text')
                ->from('fund')
                ->where(['like', 'symbol', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Fund::find($id)->symbol];
        }
        return $out;
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    /*public function actionIndex()
    {
        $searchModel = new FundSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreate()
    {
        $model = new Fund();
        $model->fund_type_in_id = 1;
        $model->dividend = 0;
        $model->currency_policy = 4;
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            if($model->save()){
                Yii::$app->session->setFlash('success', 'อัพเดทข้อมูลสำเร็จ');
            }
            else{
                Yii::$app->session->setFlash('error', 'ไม่สามารถทำรายการได้');
            }
            return $this->redirect(['index']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            if($model->save()){
                Yii::$app->session->setFlash('success', 'อัพเดทข้อมูลสำเร็จ');
            }
            else{
                Yii::$app->session->setFlash('error', 'ไม่สามารถทำรายการได้');
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Fund::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionFundList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, symbol AS text')
                ->from('fund')
                ->where(['like', 'symbol', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Fund::find($id)->symbol];
        }
        return $out;
    }
    
    public function actionPullFund(){
        //$service = new FinnominaService();
       // $fund_code = 'TMB-ES-GENOME';
        //$result = $service->getFundDetail($fund_code);
        //var_dump($result);exit();
        
        //return $this->render('pt');
    }*/
}