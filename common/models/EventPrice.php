<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "event_price".
 *
 * @property string $id
 * @property string $event_id
 * @property string $cost
 * @property string $description
 */
class EventPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id'], 'required'],
            [['event_id'], 'integer'],
            [['cost'], 'number'],
            [['description'], 'string']
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
            'cost' => 'Цена',
            'description' => 'Пояснение',
        ];
    }
}
