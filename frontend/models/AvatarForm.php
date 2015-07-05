<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 05.03.15
 * Time: 22:39
 */

namespace frontend\models;


use common\models\User;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

class AvatarForm extends Model
{
	/**
	 * @var UploadedFile
	 */
	public $img;
	public $x;
	public $y;
	public $x2;
	public $y2;
	public $w;
	public $h;
	public $oW;
	public $oH;

	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			[['x', 'y', 'x2', 'y2', 'w', 'h', 'oW', 'oH'], 'number','min'=>0,'max'=>3840],
			[
				'img',
                'image',
				'mimeTypes'  => 'image/jpg, image/jpeg, image/gif',
				'extensions' => ['jpg', 'jpeg','gif'],
				'maxSize'    => (1024 * 5 * 1024),
                'minWidth'   => 240,
                'minHeight'  => 240,
                'maxWidth'   => 3840,
                'maxHeight'  => 3840,
			],
		];
	}

	public function save(User $user)
	{
		$folder = sha1($user->username . ':' . microtime(true) . ':' . uniqid());
		$dir    = \Yii::getAlias('@webroot') . \Yii::$app->params['AVATAR_DIR'] . DIRECTORY_SEPARATOR . $folder;

		$main  = Image::getImagine()->open($this->img->tempName);
		$fW    = $main->getSize()->getWidth() / $this->oW;
		$fH    = $main->getSize()->getHeight() / $this->oH;
		$cropX = $this->x * $fW;
		$cropY = $this->y * $fH;
		$cropW = $this->w * $fW;
		$cropH = $this->h * $fH;
		FileHelper::createDirectory($dir);
		$AVATAR_EXT = \Yii::$app->params['AVATAR_EXT'];
		$main->crop(new Point($cropX, $cropY), new Box($cropW, $cropH))
			->resize(new Box(240, 240))
			->save($dir . DIRECTORY_SEPARATOR . User::AVATAR_240 . '.' . $AVATAR_EXT)
			->resize(new Box(120, 120))
			->save($dir . DIRECTORY_SEPARATOR . User::AVATAR_120 . '.' . $AVATAR_EXT)
			->resize(new Box(60, 60))
			->save($dir . DIRECTORY_SEPARATOR . User::AVATAR_60 . '.' . $AVATAR_EXT);
		unlink($this->img->tempName);
		if ($user->avatar) {
			$removeDir = \Yii::getAlias('@webroot') . \Yii::$app->params['AVATAR_DIR'] . DIRECTORY_SEPARATOR . $user->avatar;
			FileHelper::removeDirectory($removeDir);
		}
		$user->avatar = $folder;
		return $user->save();
	}
}