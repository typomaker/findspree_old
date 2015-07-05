<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "event_type".
 *
 * @property integer $id
 * @property string $name
 */
class EventType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Event Type ID',
            'name' => 'Name',
        ];
    }
}
