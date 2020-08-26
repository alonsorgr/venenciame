<?php

namespace app\controllers;

use app\helpers\Email;
use app\models\forms\RequestPartnersForm;
use Yii;
use app\models\Partners;
use app\models\search\PartnersSearch;
use app\models\States;
use app\models\User;
use yii\bootstrap4\ActiveForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * PartnersController implements the CRUD actions for Partners model.
 */
class PartnersController extends Controller
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
     * Lists all Partners models.
     * @return mixed
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
     * Displays a single Partners model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Partners model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Partners();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Partners model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
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
     * Deletes an existing Partners model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionRequest()
    {
        $model = new RequestPartnersForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
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

    public function actionStates($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return States::getStates($id);
    }

    /**
     * Finds the Partners model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Partners the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Partners::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
