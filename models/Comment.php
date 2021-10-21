<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $c_text
 * @property int $r_room
 * @property int $r_user
 * @property string $creation_date
 *
 * @property Rooms $rRoom
 * @property Users $rUser
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['c_text', 'r_room', 'r_user'], 'required'],
            [['c_text'], 'string'],
            [['r_room', 'r_user'], 'integer'],
            [['creation_date'], 'safe'],
            [['r_room'], 'exist', 'skipOnError' => true, 'targetClass' => Rooms::className(), 'targetAttribute' => ['r_room' => 'id']],
            [['r_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['r_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'c_text' => 'C Text',
            'r_room' => 'R Room',
            'r_user' => 'R User',
            'creation_date' => 'Creation Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRRoom()
    {
        return $this->hasOne(Rooms::className(), ['id' => 'r_room']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'r_user']);
    }
}
