<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
	public $username;
	public $password;
	public $rememberMe = true;

	private $_user = false;


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			// username and password are both required
			[['username', 'password'], 'required'],
			// rememberMe must be a boolean value
			['rememberMe', 'boolean'],
			// password is validated by validatePassword()
			['password', 'validatePassword'],
		];
	}

	public function attributeLabels()
	{
		return [
			'username'   => 'Логин',
			'password'   => 'Пароль',
			'rememberMe' => 'Запомнить',
		];
	}

	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 * @param string $attribute the attribute currently being validated
	 * @param array  $params    the additional name-value pairs given in the rule
	 */
	public function validatePassword($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$user = $this->getUser();
			if (!$user || !$user->validatePassword($this->password)) {
				$this->addError($attribute, 'Incorrect username or password.');
			}
		}
	}

	/**
	 * Logs in a user using the provided username and password.
	 * @return boolean whether the user is logged in successfully
	 */
	public function login()
	{
		if ($this->validate()) {
			$user = $this->getUser();
			$user->online = 1;
			$user->update(false);
			$Verified = \common\models\UserVerified::findOne(['user_id' => $user->id]);
			if(!$Verified || !$Verified->verificate_date) {
				Yii::$app->session->setFlash('verification', 'Для авторизации вам требуется подтвердить аккаунт. На указанный Вами email было выслано письмо содержащее ссылку для подтверждения аккаунта');
				return false;
			};
			return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
		} else {
			return false;
		}
	}

	/**
	 * Finds user by [[username]]
	 * @return User|null
	 */
	public function getUser()
	{
		if ($this->_user === false) {
			$this->_user = User::findByUsername($this->username);
		}

		return $this->_user;
	}
}
