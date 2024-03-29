<?php
namespace common\models;

use common\helpers\Time;
use nodge\eauth\ErrorException;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer    $id
 * @property string     $username
 * @property string     $password_hash
 * @property string     $password_reset_token
 * @property string     $email
 * @property bool       $online
 * @property string     $auth_key
 * @property integer    $status
 * @property integer    $created_at
 * @property integer    $updated_at
 * @property string(40) $avatar
 * @property Event[]    $eventSubscribe
 * @property Event[]    $eventCreate
 * @property User[]     $subscribers
 * @property User[]     $signed
 * @property string     $password write-only password
 * @method null touch($attribute)  @see TimestampBehavior::touch()
 */
class User extends ActiveRecord implements IdentityInterface
{
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 10;
	const AVATAR_240 = '240x';
	const AVATAR_120 = '120x';
	const AVATAR_60 = '60x';
	const GENDER_MALE = 1;
	const GENDER_FEMALE = 2;
	public static $sizesAvatar = [
		60  => self::AVATAR_60,
		120 => self::AVATAR_120,
		240 => self::AVATAR_240,
	];

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%user}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['status', 'default', 'value' => self::STATUS_ACTIVE],
			['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id)
	{
		return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}

	/**
	 * @param \nodge\eauth\ServiceBase $service
	 * @return User
	 * @throws ErrorException
	 */
	public static function findByEAuth($service)
	{
		if (!$service->getIsAuthenticated()) {
			throw new ErrorException('Авторизован.');
		}
		/**
		 * @var $social    UserSocial
		 * @var $socialOth UserSocial
		 */
		$email = $service->getAttribute('email');
		$social = UserSocial::findOne(['service' => $service->getServiceName(), 'service_id' => "{$service->getId()}"]);
		if ($social) {
			return $social->user;
		}
		$socialOth = $email ? UserSocial::findOne(['email' => $email]) : false;
		$user = User::findOne(['email' => $email]);
		if (!$user) {
			if (!$socialOth) {
				$user = new static([
									   'username' => $service->getAttribute('name'),
									   'email'    => $email,
									   'auth_key' => Yii::$app->security->generateRandomString()
								   ]);
				$user->insert(false);
			}
			else {
				$user = $socialOth->user;
			}
		}
		$social = new UserSocial([
									 'service'    => $service->getServiceName(),
									 'service_id' => $service->getId(),
									 'user_id'    => $user->id,
									 'email'      => $user->email
								 ]);
		$social->insert(false);
		return $user;
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token)
	{
		if (!static::isPasswordResetTokenValid($token)) {
			return null;
		}

		return static::findOne([
								   'password_reset_token' => $token,
								   'status'               => self::STATUS_ACTIVE,
							   ]);
	}

	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token password reset token
	 * @return boolean
	 */
	public static function isPasswordResetTokenValid($token)
	{
		if (empty($token)) {
			return false;
		}
		$expire = Yii::$app->params['user.passwordResetTokenExpire'];
		$parts = explode('_', $token);
		$timestamp = (int)end($parts);
		return $timestamp + $expire >= time();
	}

	/**
	 * @inheritdoc
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString();
	}

	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken()
	{
		$this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken()
	{
		$this->password_reset_token = null;
	}

	/**
	 * @param string $size
	 * @return string Урл для аватарки
	 * Показываем аватарку пользователя
	 */
	public function getAvatar($size = self::AVATAR_120)
	{
		$name = $size;
		if (!in_array($size, static::$sizesAvatar, true)) {
			$size = (int)$size;
			foreach (static::$sizesAvatar as $s) {
				$name = $s;
				if ($s >= $size) break;
			}
		}
		return $this->avatar ? Yii::$app->params['AVATAR_DIR'] . '/' . $this->avatar . '/' . $name . '.' . Yii::$app->params['AVATAR_EXT'] : false;
	}

	/**
	 * Проверяет, это модель авторизованного пользователя
	 * @return bool Если модель авторизованного пользователя то true
	 */
	public function isAuth()
	{
		return Yii::$app->user->getId() == $this->getId();
	}

	/**
	 * Заготовка, если онлайн
	 * @return bool
	 */
	public function isOnline()
	{
		return true;
	}

	public function fields()
	{
		return [
			'id',
			'username',
			'email',
			'isMy'   => function () {
				return $this->isMy();
			},
			'link'   => function () {
				return [
					'home' => Url::to(['/user/index', 'id' => $this->id])
				];
			},
			'avatar' => function () {
				return [
					'sm' => $this->getAvatar(self::AVATAR_60),
					'md' => $this->getAvatar(self::AVATAR_120),
					'lg' => $this->getAvatar(self::AVATAR_240),
				];
			}
		];
	}

	/**
	 * События на который пользователь подписан
	 * @return ActiveQuery
	 */
	public function getEventSubscribe()
	{
		return $this->hasMany(Event::className(), ['id' => 'event_id'])
					->viaTable(EventSubscriber::tableName(), ['user_id' => 'id']);
	}

	/**
	 * События которые создал
	 * @return ActiveQuery
	 */
	public function getEventCreate()
	{
		return $this->hasMany(Event::className(), ['user_id' => 'id']);
	}

	/**
	 * Просто проверяет, модель авторизованного пользователя или нет
	 * @return bool
	 */
	public function isMy()
	{
		return !Yii::$app->user->isGuest && Yii::$app->user->identity->id == $this->id;
	}

	/**
	 * Подписан ли пользовател на нас
	 * @param \common\models\User $user пользователь, подписку которого хотим проверить
	 * @return bool
	 */
	public function isSubscribed(User $user)
	{
		return $this->getSubscribers()->onCondition(['subscriber_id' => $user->id])->exists();
	}

	/**
	 * Пользователи подписанные на меня
	 * @return ActiveQuery
	 */
	public function getSubscribers()
	{
		return $this->hasMany(UserSubscriber::className(), ['user_id' => 'id']);
	}

	/**
	 * Пользователи, на которых я подписан
	 * @return ActiveQuery
	 */
	public function getSigned()
	{
		return $this->hasMany(UserSubscriber::className(), ['subscriber_id' => 'id']);
	}
}
