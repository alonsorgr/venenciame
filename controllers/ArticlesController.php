<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\controllers;

use Yii;
use app\models\Articles;
use app\models\search\ArticlesSearch;
use app\models\search\ReviewsSearch;
use app\models\User;
use yii\bootstrap4\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * Controlador de artículos.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 2.0
 */
class ArticlesController extends Controller
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
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return User::isPartner() || User::isAdmin();
                        }
                    ],
                    [
                        'actions' => ['update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Articles::isOwner() || User::isAdmin();
                        }
                    ],
                    [
                        'actions' => ['update', 'disable', 'enable'],
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
                    'delete' => Yii::$app->request->isGet ? ['get'] : ['post'],
                ],
            ],
        ];
    }

    /**
     * Acción de renderizado vista de inicio de artículos.
     *
     * @return yii\web\Response | string    el resultado de la representación.
     */
    public function actionIndex()
    {
        $searchModel = new ArticlesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Acción de renderizado vista de artículo.
     * @param   integer            $id      identificador de artículo.
     * @return  yii\web\Response | string   el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionView($id)
    {
        $reviewsSearch = new ReviewsSearch();
        $reviewsProvider = $reviewsSearch->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'reviewsSearch' => $reviewsSearch,
            'reviewsProvider' => $reviewsProvider,
        ]);
    }

    /**
     * Acción de renderizado vista de creación de artículo.
     * @return  yii\web\Response | string   el resultado de la representación.
     */
    public function actionCreate()
    {
        $model = new Articles();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash(
                    'info',
                    Yii::t('app', 'Se ha creado el artículo, en breve será moderado por los administradores y será publicado si cumple los requisitos.<br> Será informado a través del correo electrónico')
                );
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Acción de renderizado vista de edición artículo.
     * @param   integer            $id      identificador de artículo.
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
     * Acción de renderizado vista de borrado de artículo.
     * @param   integer            $id      identificador de artículo.
     * @return  yii\web\Response | string   el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('delete', [
                'model' => $model,
            ]);
        } else {
            if ($model->delete()) {
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Se ha eliminado correctamente el artículo.')
                );
                return $this->redirect(['partners/view', 'id' => $model->partner->id]);
            } else {
                Yii::$app->session->setFlash(
                    'error',
                    Yii::t('app', 'Hubo un error al eliminar el artículo, por favor, inténtelo de nuevo.')
                );
                return $this->redirect(['articles/view', 'id' => $id]);
            }
        }
    }

    /**
     * Encuentra el modelo de artículo en función de su valor de clave principal.
     * @param   integer                 $id     identificador de artículo.
     * @return  User                            el modelo cargado.
     * @throws  NotFoundHttpException           si el modelo no es encontrado.
     */
    protected function findModel($id)
    {
        if (($model = Articles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
