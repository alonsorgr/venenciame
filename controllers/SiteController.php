<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap4\Html;
use app\models\User;
use app\models\CartItems;
use app\models\forms\ContactForm;
use app\models\forms\LoginForm;
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
                'only' => ['logout', 'checkout', 'make-payment'],
                'rules' => [
                    [
                        'actions' => ['logout', 'checkout', 'make-payment'],
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

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('login', [
                'model' => $model,
            ]);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
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
        }
        Yii::$app->user->logout();
        return $this->goHome();
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
     * @param mixed $id
     * @param mixed $auth_key
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
            }
            Yii::$app->session->setFlash(
                'danger',
                Yii::t('app', 'Ocurrió un error al validar la cuenta por correo electrónico, por favor, inténtelo de nuevo.')
            );
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
     * @param mixed $id
     * @param mixed $verf_key
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
     * Acción de checkout de artículos en PayPal.
     *
     * @return yii\web\Response     el objeto de respuesta actual..
     */
    public function actionCheckout()
    {
        $model = CartItems::find()->where(['user_id' => User::id()])->all();

        $total = 0;

        foreach ($model as $value) {
            $items[] = [
                'name' => $value->article->title,
                'price' => ($value->article->price * $value->article->vat->value / 100) + $value->article->price,
                'quantity' => $value['quantity'],
                'currency' => 'EUR',
            ];

            $total += (($value->article->price * $value->article->vat->value / 100) + $value->article->price) * $value['quantity'];
        }

        $params = [
            'method' => 'paypal',
            'intent' => 'sale',
            'order' => [
                'description' => 'Payment description',
                'subtotal' => $total,
                'shippingCost' => 0,
                'total' => $total,
                'currency' => 'EUR',
                'items' => $items,
            ],
        ];


        if (Yii::$app->PayPalRestApi->checkout($params)) {
            $_SESSION['params'] = [
                'order' => [
                    'description' => $params['order']['description'],
                    'subtotal' => $params['order']['subtotal'],
                    'shippingCost' => $params['order']['shippingCost'],
                    'total' => $params['order']['total'],
                    'currency' => $params['order']['currency'],
                ],
            ];
        }
    }

    /**
     * Acción de pago de artículos en PayPal.
     *
     * @return yii\web\Response     el objeto de respuesta actual..
     */
    public function actionMakePayment()
    {
        $params = $_SESSION['params'];

        if (isset(Yii::$app->request->get()['success']) && Yii::$app->request->get()['success'] == 'true') {
            Yii::$app->PayPalRestApi->processPayment($params);
            unset($params);

            CartItems::deleteAll(['user_id' => User::id()]);

            Yii::$app->session->setFlash(
                'success',
                Yii::t('app', 'La compra se ha realizado con éxito.')
            );
            Yii::$app->session->setFlash(
                'success',
                Yii::t('app', 'Puede ver el estado de su pedido en la sección de pedidos de su perfil:') .
                Html::a(Yii::t('app', 'Mis Pedidos'), Url::to(['user/view', 'id' => User::id()]), [
                    'class' => 'ml-2 font-weight-bold',
                ])
            );
            return $this->redirect('/site/index');
        }

        Yii::$app->session->setFlash(
            'danger',
            Yii::t('app', 'No se pudo realizar la compra, por favor, inténtelo de nuevo.')
        );

        return $this->redirect('/cart-items/index');
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
