<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "feedback".
 *
 * @property string $id
 * @property string $created
 * @property string $title
 * @property string $body
 * @property string $email
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback';
    }
	public function behaviors()
	{
		return [
			[
				'class'              => TimestampBehavior::className(),
				'createdAtAttribute' => 'created',
				'updatedAtAttribute' => false
			],
		];
	}
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'body', 'email'], 'required'],
            [['title', 'body', 'email'], 'filter','filter'=>function($value){
				return htmlspecialchars($value);
			}],
            [['id', 'created'], 'integer'],
            [['body'], 'string'],
            [['title', 'email'], 'string', 'max' => 100]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created' => 'Created',
            'title' => 'Тема',
            'body' => 'Сообщение',
            'email' => 'Email',
        ];
    }
}
