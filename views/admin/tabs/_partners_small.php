<?php

/* @var $this yii\web\View */
/* @var $partnersSearchModel app\models\search\PartnersSearch */
/* @var $partnersDataProvider yii\data\ActiveDataProvider */

use yii\bootstrap4\Html;
use yii\helpers\Url;

\yii\web\YiiAsset::register($this);

?>

<div class="admin-partners-small">
    <div class="row mt-5 justify-content-start">
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Nombre de bodega'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Html::a(Html::encode($model->name), ['user/view', 'id' => $model->id], [
                        'data-pjax' => 0,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Usuario vinculado'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Html::encode($model->user->username) ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Correo electrónico'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Yii::$app->formatter->asEmail($model->email); ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Estado de la cuenta'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Html::encode($model->status->label); ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Usuario desde'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Yii::$app->formatter->asDate($model->created_at); ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center font-weight-bold mb-2">
                    <?= Yii::t('app', 'Acciones'); ?>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="d-flex justify-content-between">
                        <?= Html::a('<i class="fas fa-eye text-info"></i>', ['partners/view', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Ver el perfil del socio'),
                            'data-pjax' => 0,
                        ]);; ?>
                        <?= Html::a('<i class="fas fa-user-edit text-primary"></i>', ['partners/update', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Editar el perfil del socio'),
                            'data-pjax' => 0,
                        ]); ?>
                        <?= Html::a('<i class="fas fa-trash-alt text-danger"></i>', ['partners/delete', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Eliminar el perfil del socio'),
                            'data-pjax' => 0,
                            'data' => [
                                'confirm' => Yii::t('app', '¿Está seguro que quiere eliminar a este socio?'),
                                'method' => 'post',
                            ],
                        ]); ?>
                        <?php
                        if ($model->status_id == 3) {
                            echo Html::a('<i class="fas fa-handshake text-warning"></i>', ['partners/disable', 'id' => $model->id], [
                                'class' => 'mr-2',
                                'title' => Yii::t('app', 'Desactivar perfil del socio'),
                                'data-pjax' => 0,
                                'data' => [
                                    'confirm' => Yii::t('app', '¿Está seguro que quiere desactivar a este socio?'),
                                    'method' => 'post',
                                ],
                            ]);
                        } elseif ($model->status_id == 2) {
                            echo Html::a('<i class="fas fa-handshake text-success"></i>', ['partners/enable', 'id' => $model->id], [
                                'class' => 'mr-2',
                                'title' => Yii::t('app', 'Activar perfil del socio'),
                                'data-pjax' => 0,
                                'data' => [
                                    'confirm' => Yii::t('app', '¿Está seguro que quiere activar a este socio?'),
                                    'method' => 'post',
                                ],
                            ]);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-xl-3 horizontal-divider"></div>
</div>