<?php

namespace app\models;

use paragraph1\phpFCM\Recipient\Device;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * ContactForm is the model behind the contact form.
 */
class NotificationForm extends Model {

    public $subject;
    public $message;

//    public $token;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['subject', 'message'], 'required'], //token
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'subject' => 'Subject',
            'message' => 'Message',
//            'token' => 'Device Tocken'
        ];
    }

    public function notify() {

        define('API_ACCESS_KEY', 'AAAAOSRyA4w:APA91bGpPImQQPQTgvZQdL8qe7QbF1khXBJxe1QO8TiuC6brGSoDEDVuuObrJqqpGHFWL4bC9378DbBWWOuN-HJ4T8McJQBauctM58-lfcPB5iA9l8NgebBi7Vm4BLemyFoRGBHNQUub
');
        $msg = array
            (
            'title' => $this->subject,
            'body' => $this->message,
        );
        $fields = array
            (
//            'registration_ids' => $registrationIds,
            "to" => "/topics/price",
            'notification' => $msg
        );

        $headers = array
            (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return true;
    }

    public function notifyToUser($registrationToken) {

        define('API_ACCESS_KEY', 'AAAAOSRyA4w:APA91bGpPImQQPQTgvZQdL8qe7QbF1khXBJxe1QO8TiuC6brGSoDEDVuuObrJqqpGHFWL4bC9378DbBWWOuN-HJ4T8McJQBauctM58-lfcPB5iA9l8NgebBi7Vm4BLemyFoRGBHNQUub');
        $msg = array
            (
            'title' => $this->subject,
            'body' => $this->message,
        );
        $fields = array
            (
            'registration_ids' => $registrationToken,
            'notification' => $msg
        );

        $headers = array
            (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return true;
    }

    public function notifyToUserGoToAd($registrationToken, $roomId) {

        $msg = array
            (
            'title' => $this->subject,
            'body' => $this->message,
        );
        $fields = array
            (
            'registration_ids' => $registrationToken,
            'notification' => $msg,
            'data' => ["roomId" => $roomId]
        );

        $headers = array
            (
            'Authorization: key=AAAAOSRyA4w:APA91bGpPImQQPQTgvZQdL8qe7QbF1khXBJxe1QO8TiuC6brGSoDEDVuuObrJqqpGHFWL4bC9378DbBWWOuN-HJ4T8McJQBauctM58-lfcPB5iA9l8NgebBi7Vm4BLemyFoRGBHNQUub',
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return true;
    }

}
