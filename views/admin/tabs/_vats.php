<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $vatsSearchModel app\models\search\VatsSearch */
/* @var $vatsDataProvider yii\data\ActiveDataProvider */

?>
<div class="admin-vats-index">
    <?= Html::a('<i class="fas fa-plus mr-2"></i>' . Yii::t('app', 'Agregar tipo de IVA'), ['/vats/create'], [
        'class' => 'btn btn-primary my-5'
    ]); ?>
    <?php Pjax::begin([
        'id' => 'admin-vats-pjax',
        'timeout' => '100000',
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $vatsDataProvider,
        'filterModel' => $vatsSearchModel,
        'columns' => [
            [
                'attribute' => 'label',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Buscar por nombre de tipo de IVA',
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div class="d-flex justify-content-between">{view} {update} {delete}</div>',
                'headerOptions' => ['style' => 'width:5%'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-eye text-info"></i>', ['vats/view', 'id' => $key], [
                            'title' => Yii::t('app', 'Ver la categoría'),
                            'data-pjax' => 0,
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-edit text-primary"></i>', ['vats/update', 'id' => $key], [
                            'title' => Yii::t('app', 'Editar la categoría'),
                            'data-pjax' => 0,
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-trash-alt text-danger"></i>', ['vats/delete', 'id' => $key], [
                            'title' => Yii::t('app', 'Eliminar la categoría'),
                            'data-pjax' => 0,
                            'data' => [
                                'confirm' => Yii::t('app', '¿Está seguro que quiere eliminar a esta categoría?'),
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>