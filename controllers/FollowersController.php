<?php

namespace app\controllers;

use Yii;
use app\models\Followers;
use app\models\search\FollowersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FollowersController implements the CRUD actions for Followers model.
 */
class FollowersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Followers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FollowersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Followers model.
     * @param integer $user_id
     * @param integer $partner_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($user_id, $partner_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($user_id, $partner_id),
        ]);
    }

    /**
     * Creates a new Followers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Followers();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'user_id' => $model->user_id, 'partner_id' => $model->partner_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Followers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $user_id
     * @param integer $partner_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($user_id, $partner_id)
    {
        $model = $this->findModel($user_id, $partner_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'user_id' => $model->user_id, 'partner_id' => $model->partner_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Followers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $user_id
     * @param integer $partner_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($user_id, $partner_id)
    {
        $this->findModel($user_id, $partner_id)->delete();

        return $this->redirect(['index']);
    }

    public function actionFollow($user_id, $partner_id)
    {
        $model = Followers::find([
            'user_id' => $user_id,
            'partner_id' => $partner_id,
        ]);

        if (Yii::$app->request->isAjax && Yii::$app->request->isGet) {
            if ($model->exists()) {
                return json_encode(['class' => 'fas', 'title' => Yii::t('app', 'Dejar de seguir')]);
            } else {
                return json_encode(['class' =>'far', 'title' => Yii::t('app', 'Seguir')]);
            }
        }

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            if (!$model->exists()) {
                $model = new Followers([
                    'user_id' => $user_id,
                    'partner_id' => $partner_id,
                ]);
                if ($model->save()) {
                    return json_encode(['class' =>'fas', 'title' => Yii::t('app', 'Dejar de seguir')]);
                }
            } else {
                $model->one()->delete();
                return json_encode(['class' =>'far', 'title' => Yii::t('app', 'Seguir')]);
            }
        }
    }

    /**
     * Finds the Followers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $user_id
     * @param integer $partner_id
     * @return Followers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id, $partner_id)
    {
        if (($model = Followers::findOne(['user_id' => $user_id, 'partner_id' => $partner_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
