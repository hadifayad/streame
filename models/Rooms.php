<?php

namespace app\models;

use Yii;

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
 * @property Comment[] $comments
 * @property Followrooms[] $followrooms
 * @property PostFiles[] $postFiles
 * @property Users $rAdmin
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
            [['c_text', 'r_admin'], 'required'],
            [['c_text'], 'string'],
            [['r_admin', 'mention'], 'integer'],
            [['creation_date'], 'safe'],
            [['color1', 'color2'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 50],
            [['category'], 'string', 'max' => 200],
            [['r_admin'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['r_admin' => 'id']],
            [['mention'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['mention' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'c_text' => 'C Text',
            'r_admin' => 'R Admin',
            'creation_date' => 'Creation Date',
            'type' => 'Type',
            'category' => 'Category',
            'mention' => 'Mention',
            'color1' => 'Color1',
            'color2' => 'Color2',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments() {
        return $this->hasMany(Comment::className(), ['r_room' => 'id']);
    }

    /**
     * Gets query for [[Followrooms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFollowrooms() {
        return $this->hasMany(Followrooms::className(), ['r_room' => 'id']);
    }

    /**
     * Gets query for [[PostFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostFiles() {
        return $this->hasMany(PostFiles::className(), ['post_id' => 'id']);
    }

    /**
     * Gets query for [[RAdmin]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRAdmin() {
        return $this->hasOne(Users::className(), ['id' => 'r_admin']);
    }

    /**
     * Gets query for [[Mention0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMention0() {
        return $this->hasOne(Users::className(), ['id' => 'mention']);
    }

}
