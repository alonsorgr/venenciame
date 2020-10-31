<?php

/* @var $this yii\web\View */
/* @var $userSearchModel app\models\search\UserSearch */
/* @var $userDataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Html;
use kartik\datetime\DateTimePicker;
use app\models\Status;
use yii\helpers\Url;

\yii\web\YiiAsset::register($this);

?>

<div class="admin-users-small">
    <div class="row mt-5 justify-content-start">
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Nombre de usuario'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Html::a(Html::encode($model->username), ['user/view', 'id' => $model->id], [
                        'data-pjax' => 0,
                    ]); ?>
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
                    <?= Yii::t('app', 'Administrador del sitio'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Yii::$app->formatter->asBoolean($model->admin); ?>
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
        <div class="col-12 col-md-2 d-flex justify-content-center justify-content-xl-end">
            <div>
                <div class="text-center font-weight-bold mb-2">
                    <?= Yii::t('app', 'Acciones'); ?>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="d-flex justify-content-between admin-actions">
                        <?= Html::a('<i class="fas fa-eye text-info"></i>', ['user/view', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Ver el perfil del usuario'),
                            'data-pjax' => 0,
                        ]);; ?>
                        <?= Html::a('<i class="fas fa-user-edit text-primary"></i>', ['user/update', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Editar el perfil del usuario'),
                            'data-pjax' => 0,
                        ]); ?>
                        <?= Html::a('<i class="fas fa-trash-alt text-danger"></i>', ['user/delete', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Eliminar el perfil del usuario'),
                            'data-pjax' => 0,
                            'data' => [
                                'confirm' => Yii::t('app', '¿Está seguro que quiere eliminar a este usuario?'),
                                'method' => 'post',
                            ],
                        ]); ?>
                        <?php
                        if ($model->status_id == 3) {
                            echo Html::a('<i class="fas fa-user-slash text-warning"></i>', ['user/disable', 'id' => $model->id], [
                                'class' => 'mr-2',
                                'title' => Yii::t('app', 'Desactivar perfil del usuario'),
                                'data-pjax' => 0,
                                'data' => [
                                    'confirm' => Yii::t('app', '¿Está seguro que quiere desactivar a este usuario?'),
                                    'method' => 'post',
                                ],
                            ]);
                        } elseif ($model->status_id == 2) {
                            echo Html::a('<i class="fas fa-user text-success"></i>', ['user/enable', 'id' => $model->id], [
                                'class' => 'mr-2',
                                'title' => Yii::t('app', 'Activar perfil del usuario'),
                                'data-pjax' => 0,
                                'data' => [
                                    'confirm' => Yii::t('app', '¿Está seguro que quiere activar a este usuario?'),
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