<?php

/* @var $this yii\web\View */
/* @var $categoriesSearchModel app\models\search\CategoriesSearch */
/* @var $categoriesDataProvider yii\data\ActiveDataProvider */

use yii\bootstrap4\Html;

\yii\web\YiiAsset::register($this);

?>

<div class="admin-categories-small">
    <div class="row mt-5 justify-content-between">
        <div class="col-12 col-md-2">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Etiqueta de la categoría'); ?>
                </div>
                <div class="text-center text-md-left">
                    <?= Html::encode($model->label); ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-1">
            <div class="mx-auto">
                <div class="text-center font-weight-bold mb-2">
                    <?= Yii::t('app', 'Acciones'); ?>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="d-flex justify-content-between">
                        <?= Html::a('<i class="fas fa-eye text-info"></i>', ['categories/view', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Ver la categoría'),
                            'data-pjax' => 0,
                        ]);; ?>
                        <?= Html::a('<i class="fas fa-edit text-primary"></i>', ['categories/update', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Editar la categoría'),
                            'data-pjax' => 0,
                        ]); ?>
                        <?= Html::a('<i class="fas fa-trash-alt text-danger"></i>', ['categories/delete', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Eliminar la categoría'),
                            'data-pjax' => 0,
                            'data' => [
                                'confirm' => Yii::t('app', '¿Está seguro que quiere eliminar esta categoría?'),
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
