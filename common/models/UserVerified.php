<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 22.03.2015
 * Time: 0:48
 */

namespace common\models;


class UserVerified extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_verified';
    }
}