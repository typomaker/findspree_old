<?php
namespace frontend\models;

use common\models\User;
use common\models\UserVerified;
use Yii;
use yii\base\ErrorException;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            [
                'username',
                'unique',
                'targetClass' => '\common\models\User',
//                'message'     => 'This username has already been taken.'
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'match', 'pattern' => '/^[a-z][a-z_0-9]+$/i'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => '\common\models\User',
//                'message'     => 'This email address has already been taken.'
            ],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email'    => 'Электронная почта',
            'password' => 'Пароль'
        ];
    }

    /**
     * Signs user up.
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                $Verification = new UserVerified();
                $Verification->user_id = $user->id;
                $Verification->key = sha1($user->username.time().uniqid());
                if($Verification->save()) {
                    $this->signupNotification($user->email, $Verification->key);
                    return $user;
                }
            }
        }

        return null;
    }

    /**
     * @param $event_id
     * Уведомлеие при регистрации
	 * @todo нужно в модель Verification перенести
     */
    public static function signupNotification($email, $key)
    {
            $mailer = \Yii::$app->mailer->compose('signup-notify', ['key' => $key])
                ->setFrom('noreply@findspree.ru')
                ->setTo($email)
                ->setSubject('Подтверждение аккаунта на сайте Findspree');
            if(!$mailer->send()){
                throw new ErrorException('Validation Email not Send');
            }
    }

}
