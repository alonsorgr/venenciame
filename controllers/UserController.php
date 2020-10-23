<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\controllers;

use app\models\search\FavoritesSearch;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\bootstrap4\ActiveForm;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\models\User;
use app\models\search\UserSearch;
use app\models\search\FollowedSearch;
use yii\filters\AccessControl;

/**
 * Controlador de usuarios [[User]]
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['validation'],
                        'allow' => true
                    ],
                    [
                        'actions' => ['create','delete', 'disable', 'enable'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return User::isAdmin();
                        }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return User::isOwner() || User::isAdmin();
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Acción de renderizado vista de inicio de usuarios.
     *
     * @return yii\web\Response | string    el resultado de la representación.
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Acción de renderizado vista de usuario.
     * @param   integer            $id      identificador de usuario.
     * @return  yii\web\Response | string   el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionView($id)
    {
        $followedSearch = new FollowedSearch();
        $followedProvider = $followedSearch->search(Yii::$app->request->queryParams);

        $favoritesSearch = new FavoritesSearch();
        $favoritesProvider = $favoritesSearch->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'followedSearch' => $followedSearch,
            'followedProvider' => $followedProvider,
            'favoritesSearch' => $favoritesSearch,
            'favoritesProvider' => $favoritesProvider,
        ]);
    }

    /**
     * Acción de renderizado vista de creación de usuario.
     * @return  yii\web\Response | string   el resultado de la representación.
     */
    public function actionCreate()
    {
        $model = new User();
        $model->setScenarioCreate();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Acción de renderizado vista de edición usuario.
     * @param   integer            $id      identificador de usuario.
     * @return  yii\web\Response | string   el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenarioUpdate();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Acción de renderizado vista de borrado de usuario.
     * @param   integer            $id      identificador de usuario.
     * @return  yii\web\Response | string   el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Acción de validación de formularios.
     * @param   integer $id     identificador de usuario.
     * @return  array           de mensajes de error indexada por los ID de atributo.
     */
    public function actionValidation($id = null)
    {
        if ($id !== null) {
            $model = $this->findModel($id);
        } else {
            $model = new User();
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    /**
     * Acción de cambio de estado a activado del usuario.
     * @param   integer            $id      identificador de usuario.
     * @return  yii\web\Response            el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionEnable($id)
    {
        $model = $this->findModel($id);
        $model->status_id = 3;
        if ($model->save()) {
            Yii::$app->session->setFlash(
                'success',
                Yii::t('app', 'Se ha habilitado al usuario correctamenete.')
            );
        } else {
            Yii::$app->session->setFlash(
                'error',
                Yii::t('app', 'No se pudo habilitar al usuario.')
            );
        }

        return $this->redirect(['/admin/index']);
    }

    /**
     * Acción de cambio de estado a desactivado del usuario.
     * @param   integer            $id      identificador de usuario.
     * @return  yii\web\Response            el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionDisable($id)
    {
        $model = $this->findModel($id);
        $model->status_id = 2;
        if ($model->save()) {
            Yii::$app->session->setFlash(
                'success',
                Yii::t('app', 'Se ha deshabilitado al usuario correctamenete.')
            );
        } else {
            Yii::$app->session->setFlash(
                'error',
                Yii::t('app', 'No se pudo deshabilitar al usuario.')
            );
        }

        return $this->redirect(['/admin/index']);
    }

    /**
     * Encuentra el modelo de usuario en función de su valor de clave principal.
     * @param   integer                 $id     identificador de usuario.
     * @return  User                            el modelo cargado.
     * @throws  NotFoundHttpException           si el modelo no es encontrado.
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
