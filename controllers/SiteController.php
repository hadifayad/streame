<?php

namespace app\controllers;

use app\models\ContactForm;
use app\models\LoginForm;
use app\models\NotificationForm;
use app\models\Rooms;
use app\models\Users;
use Yii;
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

//    public function actionHello() {
//
//        $sql = "SELECT * FROM `rooms` WHERE is_challenge_finished= 0
//        and challenge_date < NOW();";
//        $command = Yii::$app->db->createCommand($sql);
//        $arrayList = $command->queryAll();
//
//
//
//        if ($arrayList) {
//
////            return $arrayList;
//            for ($i = 0; $i < sizeof($arrayList); $i++) {
//
////                $model = new Text();
////                $model->name = "size: " . $arrayList[$i]["id"];
////                if ($model->save()) {
////                    echo 'saved';
////                } else {
////                    echo 'error';
////                }
////                return;
//
//                $mention1 = $arrayList[$i]["mention"];
//                $mention2 = $arrayList[$i]["mention2"];
//                $mention3 = $arrayList[$i]["mention3"];
//                $room = Rooms::find()
//                        ->where(['id' => $arrayList[$i]["id"]])
//                        ->one();
//
//                $ids = array();
//                array_push($ids, $room->r_admin);
//
//
//
//
//
//                if ($room) {
//
//                    if ($mention3 == null && $mention2 == null) {
//
//                        $room->challenge_winner = $mention1;
//                        $room->is_challenge_finished = "1";
//                        $room->save();
//                        array_push($ids, $room->mention);
//                    } elseif ($mention3 == null) {
//                        array_push($ids, $room->mention);
//                        array_push($ids, $room->mention2);
//
//
//                        $sql_count_mention1query = " SELECT COUNT(*) AS count  FROM `challenge_voting`  WHERE r_streamer_voted = " . $mention1 . " and post_id=" . $arrayList[$i]["id"] . "";
//                        $sql_count_mention2query = " SELECT COUNT(*) AS count  FROM `challenge_voting`  WHERE r_streamer_voted = " . $mention2 . " and post_id=" . $arrayList[$i]["id"] . "";
//
//                        $command = Yii::$app->db->createCommand($sql_count_mention1query);
//                        $sql_count_mention1 = $command->queryOne();
//                        $command = Yii::$app->db->createCommand($sql_count_mention2query);
//                        $sql_count_mention2 = $command->queryOne();
//
//                        if ($sql_count_mention2["count"] > $sql_count_mention1["count"]) {
//                            $room->challenge_winner = $mention2;
//                            $room->is_challenge_finished = "1";
//                            $room->save();
//                            array_push($ids, $room->mention);
//                            $winner = $mention2;
//
////                           return $sql_count_mention1;
//                        } elseif ($sql_count_mention2["count"] < $sql_count_mention1["count"]) {
//                            $room->challenge_winner = $mention1;
//                            $room->is_challenge_finished = "1";
//                            $room->save();
//                            array_push($ids, $room->mention2);
//                            $winner = $mention1;
//
////                           return $sql_count_mention1;
//                        }
//                    } elseif ($mention3 != null && $mention2 != null && $mention1 != null) {
//
//
//
//                        $sql_count_mention1query = " SELECT COUNT(*) As count  FROM `challenge_voting`  WHERE r_streamer_voted = " . $mention1 . " and post_id=" . $arrayList[$i]["id"] . "";
//                        $sql_count_mention2query = " SELECT COUNT(*) As count   FROM `challenge_voting`  WHERE r_streamer_voted = " . $mention2 . " and post_id=" . $arrayList[$i]["id"] . "";
//                        $sql_count_mention3query = " SELECT COUNT(*) As count  FROM `challenge_voting`  WHERE r_streamer_voted = " . $mention3 . " and post_id=" . $arrayList[$i]["id"] . "";
//
//                        $command = Yii::$app->db->createCommand($sql_count_mention1query);
//                        $sql_count_mention1 = $command->queryOne();
//                        $command = Yii::$app->db->createCommand($sql_count_mention2query);
//                        $sql_count_mention2 = $command->queryOne();
//
//                        $command = Yii::$app->db->createCommand($sql_count_mention3query);
//                        $sql_count_mention3 = $command->queryOne();
//
//                        if ($sql_count_mention2["count"] > $sql_count_mention1["count"] && $sql_count_mention2["count"] > $sql_count_mention3["count"]) {
//                            $room->challenge_winner = $mention2;
//                            $room->is_challenge_finished = "1";
//                            $room->save();
//                            array_push($ids, $room->mention);
//                            $winner = $mention2;
//                            array_push($ids, $room->mention3);
//                        } elseif ($sql_count_mention2["count"] < $sql_count_mention1["count"] && $sql_count_mention3["count"] < $sql_count_mention1["count"]) {
//                            $room->challenge_winner = $mention1;
//                            $room->is_challenge_finished = "1";
//                            array_push($ids, $room->mention2);
//                            $winner = $mention1;
//                            array_push($ids, $room->mention3);
//                            $room->save();
//                        } elseif ($sql_count_mention2["count"] < $sql_count_mention3["count"] && $sql_count_mention1["count"] < $sql_count_mention3["count"]) {
//                            $room->challenge_winner = $mention3;
//                            $room->is_challenge_finished = "1";
//                            array_push($ids, $room->mention1);
//                            $winner = $mention3;
//                            array_push($ids, $room->mention2);
//                            $room->save();
//                        }
//                    }
//                }
//
//
//                $tokens = Users::find()
//                        ->select("token")
//                        ->where(["id" => $ids])
//                        ->asArray()
//                        ->column();
//                $winnerUser = Users::find()
//                        ->where(["id" => $winner])
//                        ->asArray()
//                        ->one();
//
//
//
//
//
//                $votersTokens = "SELECT  users.token as token FROM `challenge_voting`
//                                left join users on users.id = challenge_voting.r_user
//                                WHERE challenge_voting.post_id=" . $room->id;
//
//
//
//                $command = Yii::$app->db->createCommand($votersTokens);
//                $votersTokensArray = $command->queryAll();
//
//                for ($j = 0; $j < sizeof($votersTokensArray); $j++) {
//
//                    array_push($tokens, $votersTokensArray[$j]["token"]);
//                }
//                
////                \yii\helpers\VarDumper::dump($tokens,3,true);
////                die();
//
////                  return ["tokens" => $tokens,
////                    "winner" => $winnerUser,
////                    "room" => $arrayList[$i]];
//
//                NotificationForm::notifyVotersTheWinner($tokens, $winnerUser, $arrayList[$i]);
//            }
//        }
//    }

}
