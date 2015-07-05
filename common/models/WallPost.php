<?php

namespace common\models;

use Yii;
use yii\base\ErrorException;
use yii\base\Model;

/**
 * This is the model class for table "wall_post".
 * @property string  $id
 * @property string  $wall_id
 * @property integer $target_type
 * @property integer $target_id
 * @property bool $personal
 */
class WallPost extends \yii\db\ActiveRecord
{
    const TARGET_TYPE_USER = 1;
    const TARGET_TYPE_EVENT = 2;
    public $target_type=self::TARGET_TYPE_USER;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wall_post';
    }

    /**
     * Устанавливает цель, к которой привязан пост
     * @param User|Event $target
     * @return $this
     * @throws ErrorException
     */
    public function setTarget($target){
        if($target instanceof User){
            $this->target_type = self::TARGET_TYPE_USER;
        }elseif($target instanceof Event){
            $this->target_type = self::TARGET_TYPE_EVENT;
        }else{
            throw new ErrorException("Invalid Data");
        }
        $this->target_id = $target->id;
        return $this;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wall_id', 'target_type', 'target_id'], 'required'],
            [['wall_id', 'target_type', 'target_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wall_id' => 'Wall ID',
            'target_type' => 'Target Type',
            'target_id' => 'Target ID',
        ];
    }

}
