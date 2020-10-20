<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $denominationsSearchModel app\models\search\DenominationsSearch */
/* @var $denominationsDataProvider yii\data\ActiveDataProvider */

?>
<div class="admin-denominations-index">
    <?= Html::a('<i class="fas fa-plus mr-2"></i>' . Yii::t('app', 'Agregar denominación de origen'), ['/denominations/create'], [
        'class' => 'btn btn-primary my-5'
    ]); ?>
    <?php Pjax::begin([
        'id' => 'admin-denominations-pjax',
        'timeout' => '100000',
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $denominationsDataProvider,
        'filterModel' => $denominationsSearchModel,
        'columns' => [
            [
                'attribute' => 'label',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Buscar por nombre de denominación de origen',
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div class="d-flex justify-content-between">{view} {update} {delete}</div>',
                'headerOptions' => ['style' => 'width:5%'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-eye text-info"></i>', ['denominations/view', 'id' => $key], [
                            'title' => Yii::t('app', 'Ver la denominación de origen'),
                            'data-pjax' => 0,
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-edit text-primary"></i>', ['denominations/update', 'id' => $key], [
                            'title' => Yii::t('app', 'Editar la denominación de origen'),
                            'data-pjax' => 0,
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-trash-alt text-danger"></i>', ['denominations/delete', 'id' => $key], [
                            'title' => Yii::t('app', 'Eliminar la denominación de origen'),
                            'data-pjax' => 0,
                            'data' => [
                                'confirm' => Yii::t('app', '¿Está seguro que quiere eliminar a esta denominación de origen?'),
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