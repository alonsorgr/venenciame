<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categorías');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-index">
    <?= Html::a('<i class="fas fa-plus mr-md-2"></i>' . Yii::t('app', 'Agregar categoría'), ['/categories/create'], [
        'class' => 'btn btn-primary my-5'
    ]); ?>
    <?php Pjax::begin([
        'id' => 'categories-index-pjax',
        'timeout' => '100000',
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'label',
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