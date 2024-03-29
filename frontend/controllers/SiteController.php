<?php
namespace frontend\controllers;

use common\component\Controller;
use common\helpers\String;
use common\helpers\Time;
use common\models\Event;
use common\models\EventType;
use common\models\Feedback;
use common\models\Tag;
use common\models\User;
use common\models\UserVerified;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
			'eauth' => [
				// required to disable csrf validation on OpenID requests
				'class' => \nodge\eauth\openid\ControllerBehavior::className(),
				'only' => ['login'],
			],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'signup', 'login', 'contact', 'request-password-reset', 'reset-password', 'feedback', 'verificate','error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
		\Yii::$app->user->setReturnUrl(['site/index']);
		$eventTypeList = Yii::$app->db->cache(function(){
			return EventType::find()->indexBy('id')->asArray()->all();
		},Time::SEC_TO_HOUR);
        return $this->render('index',['eventTypeList'=>$eventTypeList]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
		$serviceName = Yii::$app->getRequest()->getQueryParam('service');
		if (isset($serviceName)) {
			/** @var $eauth \nodge\eauth\ServiceBase */
			$eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
			$eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
			$eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('site/login'));

			try {
				if ($eauth->authenticate()) {
					$identity = User::findByEAuth($eauth);
					Yii::$app->getUser()->login($identity);

					// special redirect with closing popup window
					$eauth->redirect();
				}
				else {
					// close popup window and redirect to cancelUrl
					$eauth->cancel();
				}
			}
			catch (\nodge\eauth\ErrorException $e) {
				// save error to show it later
				Yii::$app->getSession()->setFlash('error', 'EAuthException: '.$e->getMessage());

				// close popup window and redirect to cancelUrl
//              $eauth->cancel();
				$eauth->redirect($eauth->getCancelUrl());
			}
		}elseif ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack(Yii::$app->homeUrl);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionFeedback()
    {
        $model = new Feedback();
        $success = false;
        if ($model->load($_POST) && $model->validate()) {
            $success = $model->save(false);
        }
        return $this->render('feedback', ['model' => $model, 'success' => $success]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goBack(Yii::$app->getHomeUrl());
    }
//
//    public function actionContact()
//    {
//        $model = new ContactForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
//                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
//            } else {
//                Yii::$app->session->setFlash('error', 'There was an error sending email.');
//            }
//
//            return $this->refresh();
//        } else {
//            return $this->render('contact', [
//                'model' => $model,
//            ]);
//        }
//    }

//    /**
//     * @return string
//     * User page
//     */
//    public function actionMy()
//    {
//        $current_events = Event::find()->where(['id' => \Yii::$app->user->identity->id])->orderBy('begin desc')->all();
//        return $this->render('my', ['current_events' => $current_events]);
//    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if (\Yii::$app->request->isAjax) {
                \Yii::$app->response->format = 'json';
                return \yii\widgets\ActiveForm::validate($model);
            }

            if ($user = $model->signup()) {
                Yii::$app->session->setFlash('verification', 'Спасибо за регистрацию. На указанный Вами электронный почтовый адрес выслано письмо содержащее ссылку для активации аккаунта.');
                $this->redirect(['/site/login']);
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * @param $key
     * Verification account
     */
    public function actionVerificate($key)
    {
        $model = UserVerified::findOne(['key' => $key]);
        if ($model && !$model->verificate_date) {
            $model->verificate_date = time();
            if ($model->save()) {
                Yii::$app->session->setFlash('verification','Аккаунт активирован. Используйте свой логин и пароль для входа на сайт. ');
                $this->redirect('/site/login');
            }
        }
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'На указанный почтовый адрес отправлена инструкция по восстановлению пароля.');
                return $this->redirect('/site/login');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Извините но мы не можем сбросить пароль дя укаанного адреса.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Пароль успешно изменён.');
            return $this->redirect('/site/login');
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
