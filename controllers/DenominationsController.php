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
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\models\User;
use app\models\Denominations;
use app\models\search\DenominationsSearch;

/**
 * Controlador de usuarios [[Denominations]]
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 2.0
 */
class DenominationsController extends Controller
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
     * Acción de renderizado vista de inicio de denominaciones.
     *
     * @return yii\web\Response | string    el resultado de la representación.
     */
    public function actionIndex()
    {
        $searchModel = new DenominationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Acción de renderizado vista de denominaciones.
     * @param   integer            $id      identificador de denominaciones.
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
     * Acción de renderizado vista de creación de denominaciones.
     * @return  yii\web\Response | string   el resultado de la representación.
     */
    public function actionCreate()
    {
        $model = new Denominations();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/admin/index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Acción de renderizado vista de edición denominaciones.
     * @param   integer            $id      identificador de denominaciones.
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
     * Acción de renderizado vista de borrado de denominaciones.
     * @param   integer            $id      identificador de denominaciones.
     * @return  yii\web\Response | string   el resultado de la representación.
     * @throws  NotFoundHttpException       si el modelo no es encontrado.
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/admin/index']);
    }

    /**
     * Encuentra el modelo de denominaciones en función de su valor de clave principal.
     * @param   integer                 $id     identificador de denominaciones.
     * @return  User                            el modelo cargado.
     * @throws  NotFoundHttpException           si el modelo no es encontrado.
     */
    protected function findModel($id)
    {
        if (($model = Denominations::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
