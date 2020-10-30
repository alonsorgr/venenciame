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
use app\models\CartItems;
use app\models\search\CartItemsSearch;

/**
 * Controlador de carritos de la compra [[CartItems]]
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 3.0
 */
class CartItemsController extends Controller
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
                        'actions' => ['index', 'create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Acción de renderizado vista de inicio de carritos de la compra.
     *
     * @return yii\web\Response | string    el resultado de la representación.
     */
    public function actionIndex()
    {
        $searchModel = new CartItemsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Acción de renderizado vista de carrito de la compra.
     * @param   integer            $id      identificador de carrito de la compra.
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
     * Acción de renderizado vista de creación de carrito de la compra.
     *
     * @param integer $user_id      id del usuario.
     * @param integer $article_id   id del artículo
     * @param integer $quantity     cantidad.
     * @return  yii\web\Response | string   el resultado de la representación.
     */
    public function actionCreate($user_id, $article_id, $quantity)
    {
        $model = CartItems::find()->where(['user_id' => $user_id, 'article_id' => $article_id]);

        if ($model->exists()) {
            $model = $model->one();
            $model->quantity = $model->quantity + $quantity;
            if ($model->save()) {
                return json_encode(['actualiza']);
            }
        } else {
            $model = new CartItems();
        }

        if (Yii::$app->request->isAjax) {
            $model->user_id = $user_id;
            $model->article_id = $article_id;
            $model->quantity = $quantity;
            if ($model->save()) {
                return json_encode(['crea']);
            }
        }
    }

    /**
     * Acción de renderizado vista de edición carrito de la compra.
     * @param   integer            $id      identificador de carrito de la compra.
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
     * Acción de renderizado vista de borrado de carrito de la compra.
     * @param   integer            $id      identificador de carrito de la compra.
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
     * Encuentra el modelo de carrito de la compra en función de su valor de clave principal.
     * @param   integer                 $id     identificador de carrito de la compra.
     * @return  User                            el modelo cargado.
     * @throws  NotFoundHttpException           si el modelo no es encontrado.
     */
    protected function findModel($id)
    {
        if (($model = CartItems::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
