<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "log_main".
 *
 * @property string $id
 * @property string $method
 * @property string $data
 * @property integer $created
 * @property string $url
 * @property string $controller
 * @property string $action
 * @property integer $user_id
 * @property integer $ip
 * @property string $referrer
 * @property string $agent
 * @property string $robot
 */
class LogMain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_main';
    }
	public function behaviors()
	{
		return [
			[
				'class'              => TimestampBehavior::className(),
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
            [['method', 'created', 'url', 'controller', 'action'], 'required'],
            [['method', 'data'], 'string'],
            [['created', 'user_id'], 'integer'],
            [['url'], 'string', 'max' => 5000],
            [['controller', 'action'], 'string', 'max' => 40]
        ];
    }
	public static function find(){
		return parent::find()->select('log_main.*, INET_NTOA(log_main.ip) as ip');
	}
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'method' => 'Method',
            'data' => 'Data',
            'created' => 'Created',
            'url' => 'Url',
            'controller' => 'Controller',
            'action' => 'Action',
            'user_id' => 'User ID',
        ];
    }
	public function beforeSave($insert){
		$this->ip = new Expression('INET_ATON(:ip)',['ip'=>$this->ip]);
		return parent::beforeSave($insert);
	}
}
