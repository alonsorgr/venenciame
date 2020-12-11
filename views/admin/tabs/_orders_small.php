<?php

/* @var $this yii\web\View */
/* @var $partnersSearchModel app\models\search\PartnersSearch */
/* @var $partnersDataProvider yii\data\ActiveDataProvider */

use yii\bootstrap4\Html;
use yii\helpers\Url;

\yii\web\YiiAsset::register($this);

?>

<div class="admin-orders-small">
    <div class="row mt-5 justify-content-start">
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Usuario'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Html::a(Html::encode($model->user->username), ['user/view', 'id' => $model->user->id], [
                        'data-pjax' => 0,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Repartidor'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Html::encode($model->dealers) ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Precio total'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Yii::$app->formatter->asCurrency($model->total_price); ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Estado del pedido'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Html::encode($model->status->label); ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Pedido realizado el'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Yii::$app->formatter->asDate($model->created_at); ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2 d-flex justify-content-center justify-content-xl-end">
            <div>
                <div class="text-center font-weight-bold mb-2">
                    <?= Yii::t('app', 'Acciones'); ?>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="d-flex justify-content-between admin-actions">
                        <?= Html::a('<i class="fas fa-edit text-primary"></i>', ['orders/update', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Editar pedido'),
                            'data-pjax' => 0,
                        ]); ?>
                        <?= Html::a('<i class="fas fa-trash-alt text-danger"></i>', ['orders/delete', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Eliminar pedido'),
                            'data-pjax' => 0,
                            'data' => [
                                'confirm' => Yii::t('app', '¿Está seguro que quiere eliminar este pedido?'),
                                'method' => 'post',
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-xl-3 horizontal-divider"></div>
</div>