<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

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
    public function actionIndex($message = 'hello world') {
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

        return ExitCode::OK;
    }

}
