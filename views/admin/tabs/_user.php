<?php

/* @var $this yii\web\View */
/* @var $userSearchModel app\models\search\UserSearch */
/* @var $userDataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Html;
use kartik\datetime\DateTimePicker;
use app\models\Statuses;

\yii\web\YiiAsset::register($this);

?>

<div class="admin-users">
    <?= Html::a('<i class="fas fa-plus mr-2"></i>' . 'Registrar usuario', ['/user/create'], [
        'class' => 'btn btn-primary mt-5'
    ]); ?>
    <?php Pjax::begin([
        'id' => 'admin-users-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row">
        <div class="col-xl-12 mt-5">
            <?= GridView::widget([
                'filterModel' => $userSearchModel,
                'dataProvider' => $userDataProvider,
                'columns' => [
                    [
                        'attribute' => 'username',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Buscar por nombre de usuario',
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
                        'attribute' => 'admin',
                        'format' => 'boolean',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Buscar por administrador',
                            'prompt' => 'Buscar por tipo de cuenta',
                        ]
                    ],
                    [
                        'attribute' => 'status.label',
                        'filter' => Html::activeDropDownList($userSearchModel, 'status_id', Statuses::labels(), [
                            'class' => 'form-control',
                            'prompt' => 'Buscar por estado',
                        ]),
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'filter' => DateTimePicker::widget([
                            'model' => $userSearchModel,
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
                                return Html::a('<i class="fas fa-eye text-info"></i>', ['user/view', 'id' => $key], [
                                    'title' => Yii::t('app', 'Ver el perfil del usuario'),
                                    'data-pjax' => 0,
                                ]);
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a('<i class="fas fa-user-edit text-primary"></i>', ['user/update', 'id' => $key], [
                                    'title' => Yii::t('app', 'Editar el perfil del usuario'),
                                    'data-pjax' => 0,
                                ]);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<i class="fas fa-trash-alt text-danger"></i>', ['user/delete', 'id' => $key], [
                                    'title' => Yii::t('app', 'Eliminar el perfil del usuario'),
                                    'data-pjax' => 0,
                                    'data' => [
                                        'confirm' => Yii::t('app', '¿Está seguro que quiere eliminar a este usuario?'),
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                            'disable' => function ($url, $model, $key) {
                                if ($model->status_id == 3) {
                                    return Html::a('<i class="fas fa-user-slash text-warning"></i>', ['user/disable', 'id' => $key], [
                                        'title' => Yii::t('app', 'Desactivar perfil del usuario'),
                                        'data-pjax' => 0,
                                        'data' => [
                                            'confirm' => Yii::t('app', '¿Está seguro que quiere desactivar a este usuario?'),
                                            'method' => 'post',
                                        ],
                                    ]);
                                } elseif ($model->status_id == 2) {
                                    return Html::a('<i class="fas fa-user text-success"></i>', ['user/enable', 'id' => $key], [
                                        'title' => Yii::t('app', 'Activar perfil del usuario'),
                                        'data-pjax' => 0,
                                        'data' => [
                                            'confirm' => Yii::t('app', '¿Está seguro que quiere activar a este usuario?'),
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