<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 10.03.15
 * Time: 12:54
 */

namespace common\models;
use yii\db\ActiveRecord;
use common\helpers\Time;

class Comment extends ActiveRecord {

    public function rules()
    {
        return [
            [['event_id', 'user_id', 'message'], 'required'],
            [['message'], 'string', 'max' => 2400]
        ];
    }

    public static function tableName()
    {
        return 'comment';
    }

    public function fields(){
        return [
            'id',
//            'event_id',
            'user_id',
            'message',
            'user',
            'created' => function(){
                return Time::dateNormalize($this->created, true);
            }
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}