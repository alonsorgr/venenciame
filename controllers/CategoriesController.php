<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\models\User;
use app\models\Categories;
use app\models\search\CategoriesSearch;

/**
 * Controlador de usuarios [[Categories]]
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 2.0
 */
class CategoriesController extends Controller
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
                        'actions' => ['index', 'create', 'update', 'delete', 'view'],
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
     * Acción de renderizado vista de inicio de categorías.
     *
     * @return yii\web\Response | string    el resultado de la representación.
     */
    public function actionIndex()
    {
        $searchModel = new CategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Acción de renderizado vista de categoría.
     * @param   integer            $id      identificador de categoría.
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
     * Acción de renderizado vista de creación de categorías.
     * @return  yii\web\Response | string   el resultado de la representación.
     */
    public function actionCreate()
    {
        $model = new Categories();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/admin/index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Acción de renderizado vista de edición categorías.
     * @param   integer            $id      identificador de categorías.
     * @return  yii\web\Response | string   el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/admin/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Acción de renderizado vista de borrado de categorías.
     * @param   integer            $id      identificador de categorías.
     * @return  yii\web\Response | string   el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/admin/index']);
    }

    /**
     * Encuentra el modelo de categorías en función de su valor de clave principal.
     * @param   integer                 $id     identificador de categorías.
     * @return  User                            el modelo cargado.
     * @throws  NotFoundHttpException           si el modelo no es encontrado.
     */
    protected function findModel($id)
    {
        if (($model = Categories::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
