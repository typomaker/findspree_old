<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag_event".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $tag_id
 */
class TagEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id'], 'required'],
            [['id', 'id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Tag Event ID',
            'id' => 'Tag ID',
            'id' => 'Event ID',
        ];
    }
}
