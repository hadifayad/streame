<?php

namespace app\controllers;

use app\controllers\api\MobileController;
use app\models\Comment;
use app\models\LoginForm;
use app\models\Rooms;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
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
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['logout'],
//                'rules' => [
//                    [
//                        'actions' => ['logout'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
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
//        return "myIndex";

        $rooms = new ActiveDataProvider(['query' => Rooms::find(),
//            'pagination'=> [
//                'pageSize'=>3, 
//            ]
        ]);
        $userId = Yii::$app->user->id;
        $userId = 20; // for testing
        $sql = "SELECT rooms.*, users.profile_picture,users.fullname,followrooms.r_room as room_id_liked,
            (SELECT COUNT(id) FROM followrooms WHERE r_room = rooms.id) as number_of_likes,
            (SELECT COUNT(id) FROM comment WHERE r_room = rooms.id) as number_of_comments,
            (SELECT c_text FROM comment WHERE r_room = rooms.id ORDER BY id DESC LIMIT 1) as last_comment,
          
            
type,
            (SELECT GROUP_CONCAT(file_name SEPARATOR ',') FROM post_files WHERE post_id = rooms.id) as files
             FROM rooms
             JOIN users ON rooms.r_admin = users.id
             LEFT JOIN followrooms ON followrooms.r_room = rooms.id AND followrooms.r_user = '$userId'
           
             ORDER BY rooms.creation_date DESC;";
        $command = Yii::$app->db->createCommand($sql);
        $arrayList = $command->queryAll();
// WHERE rooms.creation_date >= CURDATE()
//          where rooms.category = 'share'



        for ($i = 0; $i < sizeof($arrayList); $i++) {
            $item = $arrayList[$i];
//            
//            if($arrayList[$i]["last_comment"]!=null && $arrayList[$i]["last_comment"]!="" ){
//                      $arrayList[$i]["comments"] = Comment::find()->where(["r_room"=>$arrayList[$i]["id"]])->asArray->all();  
//            }




            if ($item["category"] == "challenge") {
                if ($item["accept1"] == 0 && $item["accept2"] == 0 && $item["accept3"] == 0) {
                    array_splice($arrayList, $i, 1);
                } else {
                    $challengeVideos = MobileController::getChallengesVideosMentioned($item["id"], $item["mention"], $item["mention2"], $item["mention3"]);
                    $arrayList[$i]["challengesVideos"] = $challengeVideos;
                    if ($challengeVideos[0]["isChallenge"] == "0" && $challengeVideos[1]["isChallenge"] == "0" && $challengeVideos[2]["isChallenge"] == "0") {
                        array_splice($arrayList, $i, 1);
                    }
                }
            } else if ($item["category"] == "donate") {

//                $arrayList[$i]["challengesVideos"] = null;
//                
                $donations = "SELECT  SUM(user_transactions.coins) AS value_sum 
FROM user_transactions
WHERE roomId =" . $item["id"];

                $command1 = Yii::$app->db->createCommand($donations);
//              return  $command1->queryOne()["value_sum"]; 
                $itemDonate = $command1->queryOne();
                $arrayList[$i]["number_of_donates"] = $itemDonate["value_sum"];
//              
            } else {
                $arrayList[$i]["challengesVideos"] = null;
            }
        }

//        return $arrayList;
        return $this->render('index', [
                    'rooms' => $arrayList,
//                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionProfile(){
//        die();
        
        $rooms = new ActiveDataProvider(['query' => Rooms::find(),
//            'pagination'=> [
//                'pageSize'=>3, 
//            ]
        ]);
        $userId = Yii::$app->user->id;
        $userId = 20; // for testing
        $sql = "SELECT rooms.*, users.profile_picture,users.fullname,followrooms.r_room as room_id_liked,
            (SELECT COUNT(id) FROM followrooms WHERE r_room = rooms.id) as number_of_likes,
            (SELECT COUNT(id) FROM comment WHERE r_room = rooms.id) as number_of_comments,
            (SELECT c_text FROM comment WHERE r_room = rooms.id ORDER BY id DESC LIMIT 1) as last_comment,
          
            
type,
            (SELECT GROUP_CONCAT(file_name SEPARATOR ',') FROM post_files WHERE post_id = rooms.id) as files
             FROM rooms
             JOIN users ON rooms.r_admin = users.id
             LEFT JOIN followrooms ON followrooms.r_room = rooms.id AND followrooms.r_user = '$userId'
          
             ORDER BY rooms.creation_date DESC;";
        $command = Yii::$app->db->createCommand($sql);
        $arrayList = $command->queryAll();
// WHERE rooms.creation_date >= CURDATE()
//          where rooms.category = 'share'



        for ($i = 0; $i < sizeof($arrayList); $i++) {
            $item = $arrayList[$i];
//            
//            if($arrayList[$i]["last_comment"]!=null && $arrayList[$i]["last_comment"]!="" ){
//                      $arrayList[$i]["comments"] = Comment::find()->where(["r_room"=>$arrayList[$i]["id"]])->asArray->all();  
//            }




            if ($item["category"] == "challenge") {
                if ($item["accept1"] == 0 && $item["accept2"] == 0 && $item["accept3"] == 0) {
                    array_splice($arrayList, $i, 1);
                } else {
                    $challengeVideos = MobileController::getChallengesVideosMentioned($item["id"], $item["mention"], $item["mention2"], $item["mention3"]);
                    $arrayList[$i]["challengesVideos"] = $challengeVideos;
                    if ($challengeVideos[0]["isChallenge"] == "0" && $challengeVideos[1]["isChallenge"] == "0" && $challengeVideos[2]["isChallenge"] == "0") {
                        array_splice($arrayList, $i, 1);
                    }
                }
            } else if ($item["category"] == "donate") {

//                $arrayList[$i]["challengesVideos"] = null;
//                
                $donations = "SELECT  SUM(user_transactions.coins) AS value_sum 
FROM user_transactions
WHERE roomId =" . $item["id"];

                $command1 = Yii::$app->db->createCommand($donations);
//              return  $command1->queryOne()["value_sum"]; 
                $itemDonate = $command1->queryOne();
                $arrayList[$i]["number_of_donates"] = $itemDonate["value_sum"];
//              
            } else {
                $arrayList[$i]["challengesVideos"] = null;
            }
        }

            return $this->render('profile', [
                    'rooms' => $arrayList,
//                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
       
            return $this->redirect(['site/index']);
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
//        die   ();
        Yii::$app->user->logout();


        return $this->goHome();
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

    public function actionPost($postId) {

        $userId = Yii::$app->user->id;
        $userId = 20; // for testing
        $sql = "SELECT rooms.*, users.profile_picture,users.fullname,followrooms.r_room as room_id_liked,
            (SELECT COUNT(id) FROM followrooms WHERE r_room = rooms.id) as number_of_likes,
            (SELECT COUNT(id) FROM comment WHERE r_room = rooms.id) as number_of_comments,
            (SELECT c_text FROM comment WHERE r_room = rooms.id ORDER BY id DESC LIMIT 1) as last_comment,
          
            
type,
            (SELECT GROUP_CONCAT(file_name SEPARATOR ',') FROM post_files WHERE post_id = rooms.id) as files
             FROM rooms
             JOIN users ON rooms.r_admin = users.id
             LEFT JOIN followrooms ON followrooms.r_room = rooms.id AND followrooms.r_user = '$userId'
             WHERE rooms.id = '$postId'
             ORDER BY rooms.creation_date DESC;";
        $command = Yii::$app->db->createCommand($sql);
        $arrayList = $command->queryAll();

        if (sizeof($arrayList) > 0) {

            $item = $arrayList[0];

            if ($item["category"] == "challenge") {
                if ($item["accept1"] == 0 && $item["accept2"] == 0 && $item["accept3"] == 0) {
                    array_splice($arrayList, $i, 1);
                } else {
                    $challengeVideos = MobileController::getChallengesVideosMentioned($item["id"], $item["mention"], $item["mention2"], $item["mention3"]);
                    $arrayList[$i]["challengesVideos"] = $challengeVideos;
                    if ($challengeVideos[0]["isChallenge"] == "0" && $challengeVideos[1]["isChallenge"] == "0" && $challengeVideos[2]["isChallenge"] == "0") {
                        array_splice($arrayList, $i, 1);
                    }
                }
            } else if ($item["category"] == "donate") {

                $donations = "SELECT  SUM(user_transactions.coins) AS value_sum 
FROM user_transactions
WHERE roomId =" . $item["id"];

                $command1 = Yii::$app->db->createCommand($donations);
                $itemDonate = $command1->queryOne();
                $item["number_of_donates"] = $itemDonate["value_sum"];
            } else {
                $item["challengesVideos"] = null;
            }

            $commentsByPost = (new Query)
                    ->select(Comment::tableName() . ".*,users.fullname,users.profile_picture")
                    ->from(Comment::tableName())
                    ->where([
                        "r_room" => $postId
                    ])
                    ->join("join", "users", Comment::tableName() . ".r_user = users.id")
                    ->orderBy("creation_date Desc")
                    ->all();


            return $this->render('post', [
                        'room' => $item,
                        'commentsByPost' => $commentsByPost,
            ]);
        }
    }

}
