<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "event_history".
 *
 * @property string $id
 * @property string $event_id
 * @property string $action
 * @property string $before
 * @property string $after
 * @property int $created
 */
class EventHistory extends \yii\db\ActiveRecord
{
	const ACTION_CREATE = 'create';
	const ACTION_EDIT = 'edit';
	const ACTION_DELETE = 'delete';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_history';
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
            [['event_id', 'action', 'before', 'after'], 'required'],
            [['event_id'], 'integer'],
            [['action', 'before', 'after'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'action' => 'Action',
            'before' => 'Before',
            'after' => 'After',
        ];
    }
}
