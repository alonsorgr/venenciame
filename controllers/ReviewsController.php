<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\models\Reviews;
use app\models\search\ReviewsSearch;

/**
 * Controlador de reseñas.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 2.0
 */
class ReviewsController extends Controller
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
        ];
    }

    /**
     * Acción de renderizado vista de inicio de reseñas.
     *
     * @return yii\web\Response | string    el resultado de la representación.
     */
    public function actionIndex()
    {
        $searchModel = new ReviewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Acción de renderizado vista de reseñas.
     * @param   integer            $id      identificador de reseñas.
     * @return  yii\web\Response | string   el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Acción de renderizado vista de creación de reseñas.
     * @return  yii\web\Response | string   el resultado de la representación.
     */
    public function actionCreate()
    {
        $model = new Reviews();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            return $model->save();
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Acción de renderizado vista de edición reseñas.
     * @param   integer            $id      identificador de reseñas.
     * @return  yii\web\Response | string   el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Acción de renderizado vista de borrado de reseñas.
     * @param   integer            $id      identificador de reseñas.
     * @return  yii\web\Response | string   el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ((Yii::$app->request->isAjax && Yii::$app->request->isPost)) {
            if ($model->delete()) {
                return json_encode([]);
            }
        }
    }

    /**
     * Encuentra el modelo de reseñas en función de su valor de clave principal.
     * @param   integer                 $id     identificador de reseñas.
     * @return  User                            el modelo cargado.
     * @throws  NotFoundHttpException           si el modelo no es encontrado.
     */
    protected function findModel($id)
    {
        if (($model = Reviews::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
