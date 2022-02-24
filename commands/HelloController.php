<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\NotificationForm;
use app\models\Rooms;
use app\models\Users;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller {

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex() {
//        echo $message . "\n";
//        $model = new \app\models\Text();
//        $model->name = "aa";
//        if ($model->save()) {
//            echo 'saved';
//        } else {
//            echo 'error';
//        }
//        $msg = array
//            (
//            'title' => "some subject",
//            'body' => "some body",
//            "userId" => 1,
//            "challengeId" => 1,
//        );
//        $fields = array
//            (
////            'registration_ids' => ["eWG5U4bYST60ryg-NYIfFN:APA91bG9jlSW84MVGvO3Xz4tHC6xpto1Szgtz_bfkLLsyLPHqzWtk_lkjjbFyzCVPlhKLf_Bu4x4u5C7Nc1FAnI3fR_fAaSrV-_XaALDvkfsb9ZIq3eNZuTlp9Hx1-CcKgD5aihc6d7z"],
//            'registration_ids' => ["dGu5pLuDSDaTLcmLqzL27r:APA91bFn1g7i2fUwICs8mIwqxwzmJUsor9DhrF5IUKS-ElCzpG7oB-LEXfLCOerDx9fWdgtxh9wNWq47TQmxR50s4v7X5cn6JHYICGnee1CRwVCUpzCl3_D1Ct5kPiMGoM2anJ6H9WC1"],
//            'data' => $msg
//        );
//
//        $headers = array
//            (
//            'Authorization: key=AAAAOSRyA4w:APA91bGpPImQQPQTgvZQdL8qe7QbF1khXBJxe1QO8TiuC6brGSoDEDVuuObrJqqpGHFWL4bC9378DbBWWOuN-HJ4T8McJQBauctM58-lfcPB5iA9l8NgebBi7Vm4BLemyFoRGBHNQUub',
//            'Content-Type: application/json'
//        );
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//        $result = curl_exec($ch);
//        curl_close($ch);
////        return true;




        $post = Yii::$app->request->post();
        $userId = $post["userId"];
        $sql = "SELECT * FROM `rooms` WHERE is_challenge_finished= 0
and challenge_date < CURDATE();";
        $command = Yii::$app->db->createCommand($sql);
        $arrayList = $command->queryAll();

        if ($arrayList) {

//            return $arrayList;
            for ($i = 0; $i < sizeof($arrayList); $i++) {

                $mention1 = $arrayList[$i]["mention"];
                $mention2 = $arrayList[$i]["mention2"];
                $mention3 = $arrayList[$i]["mention3"];
                $room = Rooms::find()
                        ->where(['id' => $arrayList[$i]["id"]])
                        ->one();

                $ids = array();
                array_push($ids, $room->r_admin);





                if ($room) {

                    if ($mention3 == null && $mention2 == null) {

                        $room->challenge_winner = $mention1;
                        $room->is_challenge_finished = "1";
                        $room->save();
                        array_push($ids, $room->mention);
                    } elseif ($mention3 == null) {
                        array_push($ids, $room->mention);
                        array_push($ids, $room->mention2);


                        $sql_count_mention1query = " SELECT COUNT(*) AS count  FROM `challenge_voting`  WHERE r_streamer_voted = " . $mention1 . " and post_id=" . $arrayList[$i]["id"] . "";
                        $sql_count_mention2query = " SELECT COUNT(*) AS count  FROM `challenge_voting`  WHERE r_streamer_voted = " . $mention2 . " and post_id=" . $arrayList[$i]["id"] . "";

                        $command = Yii::$app->db->createCommand($sql_count_mention1query);
                        $sql_count_mention1 = $command->queryOne();
                        $command = Yii::$app->db->createCommand($sql_count_mention2query);
                        $sql_count_mention2 = $command->queryOne();

                        if ($sql_count_mention2["count"] > $sql_count_mention1["count"]) {
                            $room->challenge_winner = $mention2;
                            $room->is_challenge_finished = "1";
                            $room->save();
                            array_push($ids, $room->mention);
                            $winner = $mention2;

//                           return $sql_count_mention1;
                        } elseif ($sql_count_mention2["count"] < $sql_count_mention1["count"]) {
                            $room->challenge_winner = $mention1;
                            $room->is_challenge_finished = "1";
                            $room->save();
                            array_push($ids, $room->mention2);
                            $winner = $mention1;

//                           return $sql_count_mention1;
                        }
                    } elseif ($mention3 != null && $mention2 != null && $mention1 != null) {



                        $sql_count_mention1query = " SELECT COUNT(*) As count  FROM `challenge_voting`  WHERE r_streamer_voted = " . $mention1 . " and post_id=" . $arrayList[$i]["id"] . "";
                        $sql_count_mention2query = " SELECT COUNT(*) As count   FROM `challenge_voting`  WHERE r_streamer_voted = " . $mention2 . " and post_id=" . $arrayList[$i]["id"] . "";
                        $sql_count_mention3query = " SELECT COUNT(*) As count  FROM `challenge_voting`  WHERE r_streamer_voted = " . $mention3 . " and post_id=" . $arrayList[$i]["id"] . "";

                        $command = Yii::$app->db->createCommand($sql_count_mention1query);
                        $sql_count_mention1 = $command->queryOne();
                        $command = Yii::$app->db->createCommand($sql_count_mention2query);
                        $sql_count_mention2 = $command->queryOne();

                        $command = Yii::$app->db->createCommand($sql_count_mention3query);
                        $sql_count_mention3 = $command->queryOne();

                        if ($sql_count_mention2["count"] > $sql_count_mention1["count"] && $sql_count_mention2["count"] > $sql_count_mention3["count"]) {
                            $room->challenge_winner = $mention2;
                            $room->is_challenge_finished = "1";
                            $room->save();
                            array_push($ids, $room->mention);
                            $winner = $mention2;
                            array_push($ids, $room->mention3);
                        } elseif ($sql_count_mention2["count"] < $sql_count_mention1["count"] && $sql_count_mention3["count"] < $sql_count_mention1["count"]) {
                            $room->challenge_winner = $mention1;
                            $room->is_challenge_finished = "1";
                            array_push($ids, $room->mention2);
                            $winner = $mention1;
                            array_push($ids, $room->mention3);
                            $room->save();
                        } elseif ($sql_count_mention2["count"] < $sql_count_mention3["count"] && $sql_count_mention1["count"] < $sql_count_mention3["count"]) {
                            $room->challenge_winner = $mention3;
                            $room->is_challenge_finished = "1";
                            array_push($ids, $room->mention1);
                            $winner = $mention3;
                            array_push($ids, $room->mention2);
                            $room->save();
                        }
                    }
                }


                $tokens = Users::find()
                        ->select("token")
                        ->where(["id" => $ids])
                        ->asArray()
                        ->all();
                $winnerUser = Users::find()
                        ->where(["id" => $winner])
                        ->asArray()
                        ->one();





                $votersTokens = "SELECT  users.token as token FROM `challenge_voting`
left join users on users.id = challenge_voting.r_user
WHERE challenge_voting.post_id=" . $room->id;



                $command = Yii::$app->db->createCommand($votersTokens);
                $votersTokensArray = $command->queryAll();

                for ($j = 0; $j < sizeof($votersTokensArray); $j++) {

                    array_push($tokens, $votersTokensArray[$j]);
                }

//                  return ["tokens" => $tokens,
//                    "winner" => $winnerUser,
//                    "room" => $arrayList[$i]];

                NotificationForm::notifyVotersTheWinner($tokens, $winnerUser, $arrayList[$i]);
            }
        }

        return ExitCode::OK;
    }

}
