<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\components\MyController;

/**
 * Site controller
 */
class SiteController extends MyController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionCheckSignup() {
        if(Yii::$app->request->post()){
            $model = new SignupForm();
            $model->username = Yii::$app->request->post('username');
            $model->email = Yii::$app->request->post('email');
            $model->password = Yii::$app->request->post('password');
            $model->re_password = Yii::$app->request->post('repassword');
            $model->verifyCode = Yii::$app->request->post('verification');
            if(Yii::$app->request->post('agree') && Yii::$app->request->post('agree')==1){
                $model->agree_rule = 1;
            }
            else{
                $model->agree_rule = null;
            }
            if($model->signup()){
                return 1;
            }
            else{
                return json_encode($model->errors);
            }
            
        }
        return 0;
    }
    
    //regist login resetpw check from ajax
    public function actionCheckLogin() {
        if(Yii::$app->request->post()){
            $model = new LoginForm();
            $model->username = Yii::$app->request->post('u');
            $model->password = Yii::$app->request->post('p');
            $model->rememberMe = Yii::$app->request->post('r');
            if($model->login()){
                return 1;
            }
            else{
                return json_encode($model->errors);
            }
            
        }
        return 0;
    }
}
