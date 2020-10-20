<?php

/* @var $this yii\web\View */
/* @var $vatsSearchModel app\models\search\VatsSearch */
/* @var $vatsDataProvider yii\data\ActiveDataProvider */

use yii\bootstrap4\Html;

\yii\web\YiiAsset::register($this);

?>

<div class="admin-vats-small">
    <div class="row mt-5 justify-content-between">
        <div class="col d-flex justify-content-start">
            <div class="col-12 col-md-2">
                <div class="mx-auto">
                    <div class="text-center text-md-left font-weight-bold">
                        <?= Yii::t('app', 'Etiqueta del tipo de iva'); ?>
                    </div>
                    <div class="text-center text-md-left">
                        <?= Html::encode($model->label); ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="mx-auto">
                    <div class="text-center text-md-left font-weight-bold">
                        <?= Yii::t('app', 'Valor del tipo de iva'); ?>
                    </div>
                    <div class="text-center text-md-left">
                        <?= Html::encode($model->value); ?>
                    </div>
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
                        <?= Html::a('<i class="fas fa-eye text-info"></i>', ['vats/view', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Ver el tipo de IVA'),
                            'data-pjax' => 0,
                        ]);; ?>
                        <?= Html::a('<i class="fas fa-edit text-primary"></i>', ['vats/update', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Editar el tipo de IVA'),
                            'data-pjax' => 0,
                        ]); ?>
                        <?= Html::a('<i class="fas fa-trash-alt text-danger"></i>', ['vats/delete', 'id' => $model->id], [
                            'class' => 'mr-2',
                            'title' => Yii::t('app', 'Eliminar el tipo de IVA'),
                            'data-pjax' => 0,
                            'data' => [
                                'confirm' => Yii::t('app', '¿Está seguro que quiere eliminar este tipo de IVA?'),
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