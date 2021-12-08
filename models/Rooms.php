<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "rooms".
 *
 * @property int $id
 * @property string|null $title
 * @property string $c_text
 * @property int $r_admin
 * @property string|null $creation_date
 * @property string|null $type
 * @property string|null $category
 * @property int|null $mention
 * @property string|null $color1 
 * @property string|null $color2
 * @property string|null $video_thumbnail
 * @property Comment[] $comments
 * @property Followrooms[] $followrooms
 * @property PostFiles[] $postFiles
 * @property Users $rAdmin
 * @property  $challenge_coins
 * @property  $streamer_response
 * @property  $invitation_response
 * @property   $challenge_user_result
 * @property  $challenge_result

 * @property Users $mention0
 */
class Rooms extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'rooms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [[ 'r_admin', 'creation_date'], 'required'],
            [['c_text'], 'string'],
            [['r_admin', 'mention'], 'integer'],
            [['creation_date'], 'safe'],
            [['color1', 'color2'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 50],
            [['category', 'video_thumbnail'], 'string', 'max' => 200],
            [['r_admin'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['r_admin' => 'id']],
            [['mention'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['mention' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'c_text' => Yii::t('app', 'C Text'),
            'r_admin' => Yii::t('app', 'R Admin'),
            'creation_date' => Yii::t('app', 'Creation Date'),
            'type' => Yii::t('app', 'Type'),
            'category' => Yii::t('app', 'Category'),
            'mention' => Yii::t('app', 'Mention'),
            'challenge_coins' => Yii::t('app', 'Challenge Coins'),
            'streamer_response' => Yii::t('app', 'streamer response'),
            'invitation_response' => Yii::t('app', 'invitation response'),
            'challenge_result' => Yii::t('app', 'challenge result'),
            'video_thumbnail' => 'Video Thumbnail',
            'challenge_user_result' => Yii::t('app', 'challenge user result'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getComments() {
        return $this->hasMany(Comment::className(), ['r_room' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getFollowrooms() {
        return $this->hasMany(Followrooms::className(), ['r_room' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPostFiles() {
        return $this->hasMany(PostFiles::className(), ['post_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRAdmin() {
        return $this->hasOne(Users::className(), ['id' => 'r_admin']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMention0() {
        return $this->hasOne(Users::className(), ['id' => 'mention']);
    }

}
