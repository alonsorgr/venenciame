<?php

/* @var $this yii\web\View */
/* @var $partnersSearchModel app\models\search\PartnersSearch */
/* @var $partnersDataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Html;
use kartik\datetime\DateTimePicker;
use app\models\Statuses;

\yii\web\YiiAsset::register($this);

?>

<div class="admin-partners">
    <?= Html::a('<i class="fas fa-plus mr-md-2"></i>' . Yii::t('app', 'Registrar socio'), ['/partners/create'], [
        'class' => 'btn btn-primary mt-5'
    ]); ?>
    <?php Pjax::begin([
        'id' => 'admin-partners-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row">
        <div class="col-xl-12 mt-5">
            <?= GridView::widget([
                'filterModel' => $partnersSearchModel,
                'dataProvider' => $partnersDataProvider,
                'columns' => [
                    [
                        'attribute' => 'name',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Buscar por nombre de usuario',
                        ]
                    ],
                    [
                        'attribute' => 'user.username',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Buscar por administrador',
                            'prompt' => 'Buscar por tipo de cuenta',
                        ]
                    ],
                    [
                        'attribute' => 'email',
                        'format' => 'email',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Buscar por correo electrónico',
                        ]
                    ],
                    [
                        'attribute' => 'status.label',
                        'filter' => Html::activeDropDownList($partnersSearchModel, 'status_id', Statuses::labels(), [
                            'class' => 'form-control',
                            'prompt' => 'Buscar por estado',
                        ]),
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'filter' => DateTimePicker::widget([
                            'model' => $partnersSearchModel,
                            'attribute' => 'created_at',
                            'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                            'pluginOptions' => [
                                'autoclose' => true,
                            ],
                            'options' => [
                                'placeholder' => 'Buscar por fecha de registro',
                            ]
                        ])
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '<div class="d-flex justify-content-between">{view} {update} {disable} {delete}</div>',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('<i class="fas fa-eye text-info"></i>', ['partners/view', 'id' => $key], [
                                    'title' => Yii::t('app', 'Ver el perfil del socio'),
                                    'data-pjax' => 0,
                                ]);
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a('<i class="fas fa-edit text-primary"></i>', ['partners/update', 'id' => $key], [
                                    'title' => Yii::t('app', 'Editar el perfil del socio'),
                                    'data-pjax' => 0,
                                ]);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<i class="fas fa-trash-alt text-danger"></i>', ['partners/delete', 'id' => $key], [
                                    'title' => Yii::t('app', 'Eliminar el perfil del socio'),
                                    'data-pjax' => 0,
                                    'data' => [
                                        'confirm' => Yii::t('app', '¿Está seguro que quiere eliminar a este socio?'),
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                            'disable' => function ($url, $model, $key) {
                                if ($model->status_id == 3) {
                                    return Html::a('<i class="fas fa-handshake text-warning"></i>', ['partners/disable', 'id' => $key], [
                                        'title' => Yii::t('app', 'Desactivar perfil del socio'),
                                        'data-pjax' => 0,
                                        'data' => [
                                            'confirm' => Yii::t('app', '¿Está seguro que quiere desactivar a este socio?'),
                                            'method' => 'post',
                                        ],
                                    ]);
                                } elseif ($model->status_id == 2) {
                                    return Html::a('<i class="fas fa-handshake text-success"></i>', ['partners/enable', 'id' => $key], [
                                        'title' => Yii::t('app', 'Activar perfil del socio'),
                                        'data-pjax' => 0,
                                        'data' => [
                                            'confirm' => Yii::t('app', '¿Está seguro que quiere activar a este socio?'),
                                            'method' => 'post',
                                        ],
                                    ]);
                                }
                            }
                        ],
                    ],
                ],
            ]); ?>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>