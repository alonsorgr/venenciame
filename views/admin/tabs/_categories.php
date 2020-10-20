<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $categoriesSearchModel app\models\search\CategoriesSearch */
/* @var $categoriesDataProvider yii\data\ActiveDataProvider */

?>
<div class="admin-categories-index">
    <?= Html::a('<i class="fas fa-plus mr-md-2"></i>' . Yii::t('app', 'Agregar categoría'), ['/categories/create'], [
        'class' => 'btn btn-primary my-5'
    ]); ?>
    <?php Pjax::begin([
        'id' => 'admin-categories-pjax',
        'timeout' => '100000',
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $categoriesDataProvider,
        'filterModel' => $categoriesSearchModel,
        'columns' => [
            [
                'attribute' => 'label',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Buscar por nombre de categoría',
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div class="d-flex justify-content-between">{view} {update} {delete}</div>',
                'headerOptions' => ['style' => 'width:5%'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-eye text-info"></i>', ['categories/view', 'id' => $key], [
                            'title' => Yii::t('app', 'Ver la categoría'),
                            'data-pjax' => 0,
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-edit text-primary"></i>', ['categories/update', 'id' => $key], [
                            'title' => Yii::t('app', 'Editar la categoría'),
                            'data-pjax' => 0,
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-trash-alt text-danger"></i>', ['categories/delete', 'id' => $key], [
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