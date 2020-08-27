<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\controllers;

use app\helpers\Cookies;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\bootstrap4\ActiveForm;
use app\models\User;
use app\models\forms\LoginForm;
use app\models\forms\ContactForm;
use app\models\forms\RegisterForm;
use app\models\forms\RequestPasswordForm;
use app\models\forms\ResetPasswordForm;

/**
 * Controlador del sitio.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => Yii::$app->request->isGet ? ['get'] : ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => !YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Acción de renderizado vista de inicio del sitio.
     *
     * @return yii\web\Response | string    el resultado de la representación.
     */
    public function actionIndex()
    {
        /* $faker = \Faker\Factory::create();
        for ( $i = 1; $i <= 2000; $i++ )
        {
            $user = new User();
            $user->username = $faker->username;
            $user->password = '123';
            $user->email = $faker->email;
            $user->save();
      
        } */
        return $this->render('index');
    }

    /**
     * Acción de renderizado de vista de conexión de usuarios.
     *
     * @return yii\web\Response | string    el objeto de respuesta actual | el resultado de la representación.
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('login', [
                'model' => $model,
            ]);
        } else {
            return $this->goBack();
        }
    }

    /**
     * Acción de renderizado de vista de desconexión de usuarios.
     *
     * @return yii\web\Response | string    el objeto de respuesta actual | el resultado de la representación.
     */
    public function actionLogout()
    {
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('logout');
        } else {
            Yii::$app->user->logout();
            return $this->goHome();
        }
    }

    /**
     * Acción de renderizado de vista de registro de usuarios.
     *
     * @return yii\web\Response | string    el objeto de respuesta actual | el resultado de la representación.
     */
    public function actionRegister()
    {
        $model = new RegisterForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->register()) {
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Se ha registrado correctamenete, confirme su cuenta en su dirección de correo electrónico.')
                );
                return $this->goHome();
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('register', [
                'model' => $model,
            ]);
        }

        return $this->goHome();
    }

    /**
     * Acción de renderizado de vista de activación registro de usuarios.
     *
     * @return yii\web\Response    el objeto de respuesta actual.
     */
    public function actionActivateAccount($id, $auth_key)
    {
        $model = User::find()->where(['id' => $id])->one();

        if ($model->validateAuthKey($auth_key)) {
            $model->removeAuthKey();
            $model->setActive();
            if ($model->save()) {
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Su dirección de correo electrónico ha sido confirmada, ahora puede iniciar sesión.')
                );
                return $this->goBack();
            } else {
                Yii::$app->session->setFlash(
                    'danger',
                    Yii::t('app', 'Ocurrió un error al validar la cuenta por correo electrónico, por favor, inténtelo de nuevo.')
                );
            }
        }
        return $this->goHome();
    }

    /**
     * Acción de renderizado de vista de petición de recuperación de contraseña de usuarios.
     *
     * @return yii\web\Response | string    el objeto de respuesta actual | el resultado de la representación.
     */
    public function actionRequestPassword()
    {
        $model = new RequestPasswordForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->request()) {
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Se ha enviado a su direeción de correo electrónico las instrucciones para restablecer su contraseña. Si no le ha llegado el correo electrónico, puede volver a enviarlo.')
                );
            } else {
                Yii::$app->session->setFlash(
                    'danger',
                    Yii::t('app', 'Ocurrió un error al enviar el correo electrónico, por favor, inténtelo de nuevo.')
                );
            }
        }

        return $this->render('request-password', [
            'model' => $model,
        ]);
    }

    /**
     * Acción de renderizado de vista de petición de restablecimiento de contraseña de usuarios.
     *
     * @return yii\web\Response | string    el objeto de respuesta actual | el resultado de la representación.
     */
    public function actionResetPassword($id, $verf_key)
    {
        $model = new ResetPasswordForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $model->getUser($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model !== null) {
                if ($model->user->validatePasswordVerfKey($verf_key)) {
                    if ($model->reset()) {
                        Yii::$app->session->setFlash(
                            'success',
                            Yii::t('app', 'La contraseña se modificó correctamente, conéctese con su nueva contraseña.')
                        );
                        return $this->goHome();
                    }
                } else {
                    Yii::$app->session->setFlash(
                        'warning',
                        Yii::t('app', 'La dirección de correo electtrónico no se ha podido autenticar.')
                    );
                }
            }
        }

        return $this->render('reset-password', [
            'model' => $model,
        ]);
    }

    /**
     * Acción de renderizado de vista de contacto.
     *
     * @return yii\web\Response | string    el objeto de respuesta actual | el resultado de la representación.
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->contact()) {
                Yii::$app->session->setFlash('contactFormSubmitted');
            } else {
                Yii::$app->session->setFlash(
                    'danger',
                    Yii::t('app', 'Ocurrió un error al enviar el correo electrónico, por favor, inténtelo más tarde.')
                );
            }
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Acción de renderizado de vista de acerca de.
     *
     * @return string    el resultado de la representación.
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
