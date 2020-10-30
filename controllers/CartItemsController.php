<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\controllers;

use app\models\Articles;
use Yii;
use app\models\CartItems;
use app\models\search\CartItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
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
     * @return  yii\web\Response | string   el resultado de la representación.
     */
    public function actionCreate($user_id, $article_id, $quantity)
    {
        //TODO: Actualizar documentación

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
                return json_encode(['si']);
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
                return json_encode(['hola']);
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
