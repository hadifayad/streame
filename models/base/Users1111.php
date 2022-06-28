<?php

// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use app\models\Village;
use mdm\admin\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "user".
 *
 * @property integer $id
 * @property string $username


 * 
 * 
 * 	
  /**
 * This is the model class for table "user".
 * @property string $address
 * @property int $id
 * @property string|null $username
 * @property string $fullname
 * @property string $phone
 * @property int $village
 * @property int $user_role
 * @property string $mandoobmohafaza
 * @property int $mandoobId
 * @property string|null $auth_key
 * @property string|null $password_hash
 * @property string|null $password_reset_token
 * @property int $status
 * @property int $mandoobId
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string $password
 * @property string $token
 * @property string $email
 * @property string $second_phone
 * @property string $profile_picture
 * @property Contract[] $contracts
 * @property UserPlants[] $userPlants
 * @property Village $village0
 */
abstract class Users extends User {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {



        return [
            [['fullname', 'phone', 'password'], 'required'],
            [['village', 'status', 'created_at', 'updated_at', 'mandoobId', 'user_role'], 'integer'],
            [['username', 'auth_key', 'profile_picture', "second_phone", "email"], 'string', 'max' => 32],
            [['fullname', 'phone', 'address', 'password', 'token', "mandoobmohafaza"], 'string', 'max' => 255],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 256],
            [['username'], 'unique', 'message' => 'This username has already been taken.'],
            [['village'], 'exist', 'skipOnError' => true, 'targetClass' => Village::className(), 'targetAttribute' => ['village' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'fullname' => Yii::t('app', 'Fullname'),
            'password' => Yii::t('app', 'Password'),
            'phone' => Yii::t('app', 'Phone'),
            'village' => Yii::t('app', 'Village'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'status' => Yii::t('app', 'Status'),
            'address' => Yii::t('app', 'Address'),
            'mandoobId' => Yii::t('app', 'mandoobId'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'profile_picture' => Yii::t('app', 'profile_picture '),
            'mandoobId' => Yii::t('app', 'mandoobId'),
            'user_role' => Yii::t('app', 'role'),
            'mandoobmohafaza' => Yii::t('app', 'mandoobmohafaza'),
        ];
    }

    public function getVillage0() {

        return $this->hasOne(Village::className(), ['id' => 'village']);
    }

    public function getUserPlants() {

        return $this->hasMany(UserPlants::className(), ['user_id' => 'id']);
    }

    public function getContracts() {

        return $this->hasMany(Contract::className(), ['user_id' => 'id']);
    }

}
