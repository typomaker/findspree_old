<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_social".
 *
 * @property string $id
 * @property string $service
 * @property string $service_id
 * @property integer $created
 * @property string $user_id
 * @property string $email
 * @property User $user
 */
class UserSocial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_social';
    }
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
            'class' => TimestampBehavior::className(),
            'createdAtAttribute' => 'created',
            'updatedAtAttribute' => false,
        ],
		];
	}
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service', 'service_id', 'created', 'user_id', 'email'], 'required'],
            [['service'], 'string'],
            [['service_id', 'created', 'user_id'], 'integer'],
            [['email'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service' => 'Service',
            'service_id' => 'Service ID',
            'created' => 'Created',
            'user_id' => 'User ID',
            'email' => 'Email',
        ];
    }
	public function getUser(){
		return $this->hasOne(User::className(),['id'=>'user_id']);
	}
}
