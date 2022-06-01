<?php

namespace app\models;

use app\models\base\Users as BaseUsers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "user".
 */
class Users extends BaseUsers {

    const ROLE_ADMIN = 'Administrator';
    const ROLE_SUPERVISOR = 'Supervisor';

    public $role;

//    public $password;

    public function behaviors() {
        return ArrayHelper::merge(
                        parent::behaviors(), [
                        # custom behaviors
                        ]
        );
    }

    public function rules() {
        return ArrayHelper::merge(
                        parent::rules(), [
                    ['username', 'filter', 'filter' => 'trim'],
                    ['username', 'string', 'min' => 2, 'max' => 255],
//                    ['password', 'required', 'on' => 'create'],
//                    ['password', 'string', 'min' => 6],
                    [['role'], 'safe'],
                        # custom validation rules
                        ]
        );
    }

    public function attributeLabels() {
        return ArrayHelper::merge(parent::attributeLabels(), [
                    'role' => Yii::t('user', 'Role'),
//                    'password' => Yii::t('user', 'Password'),
                    'actions' => Yii::t('user', 'Actions'),
                    'branch' => 'Branch',
        ]);
    }

    public static function getUser($id) {
        $model = Users::find()
                        ->select('user.*,auth_item.name as role')
                        ->leftJoin('auth_assignment', 'auth_assignment.user_id=user.id')
                        ->leftJoin('auth_item', 'auth_item.name = auth_assignment.item_name')
                        ->where(['user.id' => $id])->all();
        return $model[0];
    }

    public function signup() {
        if ($this->validate()) {
            $this->setPassword($this->password);
            $this->generateAuthKey();
            if ($this->save()) {
                return $this;
            }
        } else {
            VarDumper::dump($this->getErrors(), 3, true);
            die();
        }
        return null;
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        return self::findOne(['auth_key' => $token]);
    }

    public static function getRoles() {
        return [
            self::ROLE_ADMIN => Yii::t("user", self::ROLE_ADMIN),
//            self::ROLE_BRANCH => Yii::t("user", self::ROLE_BRANCH),
//            self::ROLE_SERVICE_CENTER => Yii::t("user", self::ROLE_SERVICE_CENTER),
            self::ROLE_SUPERVISOR => Yii::t("user", self::ROLE_SUPERVISOR),
//            self::ROLE_PATIENT => Yii::t("user", self::ROLE_PATIENT),
        ];
    }

    public static function isAdminRole() {
        $model = Users::find()
                        ->select('user.*,auth_item.name as role')
                        ->leftJoin('auth_assignment', 'auth_assignment.user_id=user.id')
                        ->leftJoin('auth_item', 'auth_item.name = auth_assignment.item_name')
                        ->where(['auth_item.type' => 1,
                            'user.id' => Yii::$app->user->id])->asArray()->all();


        if (isset($model) && isset($model[0]) && $model[0]['role'] == Users::ROLE_ADMIN) {
            return true;
        }
        return false;
    }

//    public static function isBranchRole() {
//        $model = Users::find()
//                        ->select('user.*,auth_item.name as role')
//                        ->leftJoin('auth_assignment', 'auth_assignment.user_id=user.id')
//                        ->leftJoin('auth_item', 'auth_item.name = auth_assignment.item_name')
//                        ->where(['auth_item.type' => 1,
//                            'user.id' => Yii::$app->user->id])->asArray()->all();
//
//        if (isset($model) && isset($model[0]) && $model[0]['role'] == Users::ROLE_BRANCH) {
//            return true;
//        }
//        return false;
//    }

    public static function isSupervisorRole() {
        $model = Users::find()
                        ->select('user.*,auth_item.name as role')
                        ->leftJoin('auth_assignment', 'auth_assignment.user_id=user.id')
                        ->leftJoin('auth_item', 'auth_item.name = auth_assignment.item_name')
                        ->where(['auth_item.type' => 1,
                            'user.id' => Yii::$app->user->id])->asArray()->all();

        if (isset($model) && isset($model[0]) && $model[0]['role'] == Users::ROLE_SUPERVISOR) {
            return true;
        }
        return false;
    }

//    public static function isServiceRole() {
//        $model = Users::find()
//                        ->select('user.*,auth_item.name as role')
//                        ->leftJoin('auth_assignment', 'auth_assignment.user_id=user.id')
//                        ->leftJoin('auth_item', 'auth_item.name = auth_assignment.item_name')
//                        ->where(['auth_item.type' => 1,
//                            'user.id' => Yii::$app->user->id])->asArray()->all();
//
//        if (isset($model) && isset($model[0]) && $model[0]['role'] == Users::ROLE_SERVICE_CENTER) {
//            return true;
//        }
//        return false;
//    }
//    public static function isAdminRole() {
//        $model = User::find()
//                        ->select('user.*,auth_item.name as role')
//                        ->leftJoin('auth_assignment', 'auth_assignment.user_id=user.id')
//                        ->leftJoin('auth_item', 'auth_item.name = auth_assignment.item_name')
//                        ->where(['auth_item.type' => 1,
//                            'user.id' => Yii::$app->user->id])->asArray()->all();
//
//
//        if (isset($model) && isset($model[0]) && $model[0]['role'] == User::ROLE_ADMIN) {
//            return true;
//        }
//        return false;
//    }
}
