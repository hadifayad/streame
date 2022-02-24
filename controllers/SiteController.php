<?php

namespace app\controllers;

use app\models\ContactForm;
use app\models\LoginForm;
use app\models\PriceInLebanese;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use const YII_ENV_TEST;

class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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
    public function actions() {
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
     * @return string
     */
    public function actionIndex() {

//        $lastPriceModel = PriceInLebanese::find()
//                ->orderBy("date desc")
//                ->limit(1)
//                ->all();
//
//        if ($lastPriceModel) {
//            $lastPrice = $lastPriceModel[0];
//        }
//        $dateformat = new Expression("DATE_FORMAT(`date`, '%m-%d') as date");
//
//        $subquery = (new \yii\db\Query)
//                ->from(PriceInLebanese::tableName())
//                ->orderBy("date desc")
//                ->limit(7);
//        $query = PriceInLebanese::find()
//                ->select(["buy_price", "sell_price", $dateformat])
//                ->from($subquery)
//                ->orderBy("date asc");
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
////            'pagination' => array('pageSize' => 10),
//            'pagination' => false,
//        ]);

        return "myIndex";

        return $this->render('index', [
//                    'lastPrice' => $lastPrice,
//                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
            return $this->redirect(['price-in-lebanese/index']);
        }

        $model->password = '';
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }

}
