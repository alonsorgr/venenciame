<?php

/* @var $this yii\web\View */
/* @var $articlesSearchModel app\models\search\ArticlesSearch */
/* @var $articlesDataProvider yii\data\ActiveDataProvider */

use yii\bootstrap4\Html;
use yii\helpers\Url;

\yii\web\YiiAsset::register($this);

?>

<div class="admin-articles-small">
    <div class="row mt-5 justify-content-start">
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Nombre del artículo'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Html::a(Html::encode($model->title), ['articles/view', 'id' => $model->id], [
                        'data-pjax' => 0,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Socio'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Html::encode($model->partner->name) ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Capacidad'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Html::encode($model->capacity) . 'cl.'; ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Estado del artículo'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Html::encode($model->status->label); ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Publicado el'); ?>
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
                        <?= Html::a('<i class="fas fa-eye text-info"></i>', ['articles/view', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Ver el el artículo'),
                            'data-pjax' => 0,
                        ]);; ?>
                        <?= Html::a('<i class="fas fa-edit text-primary"></i>', ['articles/update', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Editar el el artículo'),
                            'data-pjax' => 0,
                        ]); ?>
                        <?= Html::a('<i class="fas fa-trash-alt text-danger"></i>', ['articles/delete', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Eliminar el el artículo'),
                            'data-pjax' => 0,
                            'data' => [
                                'confirm' => Yii::t('app', '¿Está seguro que quiere eliminar a este socio?'),
                                'method' => 'post',
                            ],
                        ]); ?>
                        <?php
                        if ($model->status_id == 3) {
                            echo Html::a('<i class="fas fa-handshake text-warning"></i>', ['articles/disable', 'id' => $model->id], [
                                'class' => 'mr-2',
                                'title' => Yii::t('app', 'Desactivar el artículo'),
                                'data-pjax' => 0,
                                'data' => [
                                    'confirm' => Yii::t('app', '¿Está seguro que quiere desactivar a este socio?'),
                                    'method' => 'post',
                                ],
                            ]);
                        } elseif ($model->status_id == 2) {
                            echo Html::a('<i class="fas fa-handshake text-success"></i>', ['articles/enable', 'id' => $model->id], [
                                'class' => 'mr-2',
                                'title' => Yii::t('app', 'Activar el artículo'),
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