<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\bootstrap4\ActiveForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\models\User;
use app\models\Partners;
use app\models\forms\RequestPartnersForm;
use app\models\search\PartnersSearch;
use app\models\search\ArticlesPartnersSearch;
use app\models\search\ArticlesPartnersViewSearch;
use app\models\search\FollowersSearch;
use yii\helpers\Url;
use app\helpers\Email;
use app\models\Statuses;

/**
 * Controlador de socios [[Partners]]
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class PartnersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['request'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Partners::isOwner() || User::isAdmin();
                        }
                    ],
                    [
                        'actions' => ['create', 'update', 'delete', 'disable', 'enable'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return User::isAdmin();
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Acción de renderizado vista de inicio de socios.
     * @return yii\web\Response | string    el resultado de la representación.
     */
    public function actionIndex()
    {
        $searchModel = new PartnersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Acción de renderizado vista de socio.
     * @param   integer            $id      identificador de socio.
     * @return  yii\web\Response | string   el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionView($id)
    {
        $followersSearch = new FollowersSearch();
        $followersProvider = $followersSearch->search(Yii::$app->request->queryParams);

        $articlesSearch = new ArticlesPartnersSearch();
        $articlesProvider = $articlesSearch->search(Yii::$app->request->queryParams);

        $articlesViewsSearch = new ArticlesPartnersViewSearch();
        $articlesViewsProvider = $articlesViewsSearch->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'followersSearch' => $followersSearch,
            'followersProvider' => $followersProvider,
            'articlesSearch' => $articlesSearch,
            'articlesProvider' => $articlesProvider,
            'articlesViewsSearch' => $articlesViewsSearch,
            'articlesViewsProvider' => $articlesViewsProvider,
        ]);
    }

    /**
     * Acción de renderizado vista de creación de socio.
     * @return  yii\web\Response | string   el resultado de la representación.
     */
    public function actionCreate()
    {
        $model = new Partners();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Acción de renderizado vista de edición socio.
     * @param   integer            $id      identificador de socio.
     * @return  yii\web\Response | string   el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Acción de renderizado vista de borrado de socio.
     * @param   integer            $id      identificador de socio.
     * @return  yii\web\Response | string   el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Acción de renderizado de vista de petición de socio.
     * @return  yii\web\Response | string   el resultado de la representación.
     */
    public function actionRequest()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash(
                'warning',
                Yii::t('app', 'Debe estar registrado en la web para poder participar y ser nuestros socios.')
            );
            return $this->redirect(['site/index']);
        }

        $model = new RequestPartnersForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $exists = Partners::find()->where(['user_id' => User::id()])->exists();

            if ($exists) {
                Yii::$app->session->setFlash(
                    'warning',
                    Yii::t('app', 'Su cuenta de usurario ya tiene vinculada una cuenta de socio.')
                );
                return $this->redirect(['site/index']);
            }
            if ($model->request()) {
                Yii::$app->session->setFlash('partnersFormSubmitted');
                Email::send([
                    'email' => $model->user->email,
                    'subject' => Yii::t('app', 'VENÉNCIAME - SOLICITUD DE SOCIO'),
                    'body' => Yii::t('app', 'Se ha creado una petición de socio en nuestra base de datos. Pronto será informado del estado de su solicitud mediante correo electrónico.'),
                ]);
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Se ha creado una petición de socio en nuestra base de datos. Pronto será informado del estado de su solicitud mediante correo electrónico.')
                );
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash(
                    'danger',
                    Yii::t('app', 'Ocurrió un error al enviar el correo electrónico, por favor, inténtelo de nuevo.')
                );
                return $this->refresh();
            }
        }
        return $this->render('request', [
            'model' => $model,
        ]);
    }

    /**
     * Acción de cambio de estado a activado del socio.
     * @param   integer            $id      identificador de socio.
     * @return  yii\web\Response            el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionEnable($id)
    {
        $model = $this->findModel($id);
        $model->status_id = Statuses::STATUS_ACTIVE;
        if ($model->save()) {
            Yii::$app->session->setFlash(
                'success',
                Yii::t('app', 'Se ha habilitado al socio correctamenete.')
            );
        } else {
            Yii::$app->session->setFlash(
                'error',
                Yii::t('app', 'No se pudo habilitar al socio.')
            );
        }
        return $this->redirect(['/admin/index']);
    }

    /**
     * Acción de cambio de estado a desactivado del socio.
     * @param   integer            $id      identificador de socio.
     * @return  yii\web\Response            el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionDisable($id)
    {
        $model = $this->findModel($id);
        $model->status_id = Statuses::STATUS_INACTIVE;
        if ($model->save()) {
            Yii::$app->session->setFlash(
                'success',
                Yii::t('app', 'Se ha deshabilitado al socio correctamenete.')
            );
            Email::send([
                'email' => $model->user->email,
                'subject' => Yii::t('app', 'VENÉNCIAME - CUENTA DESHABILITADA'),
                'body' => Email::link([
                    'body' => Yii::t('app', 'Su cuenta de socio ha sido deshabilitada por el administrador.'),
                    'url' => Url::to(['site/contact'], true),
                    'text' => Yii::t('app', 'Contacto'),
                ]) ,
            ]);
        } else {
            Yii::$app->session->setFlash(
                'error',
                Yii::t('app', 'No se pudo deshabilitar al socio.')
            );
        }
        return $this->redirect(['/admin/index']);
    }


    /**
     * Encuentra el modelo de socio en función de su valor de clave principal.
     * @param   integer                 $id     identificador de socio.
     * @return  User                            el modelo cargado.
     * @throws  NotFoundHttpException           si el modelo no es encontrado.
     */
    protected function findModel($id)
    {
        if (($model = Partners::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
