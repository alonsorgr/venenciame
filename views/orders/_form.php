<?php

use app\helpers\Bootstrap;
use app\models\Status;
use app\models\User;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="orders-form">
    <?php $form = ActiveForm::begin([
        'id' => 'orders-form',
        'enableAjaxValidation' => true,
    ]); ?>
    <div class="row">
        <div class="col-xl-12 mb-3">
            <?= Bootstrap::header(Yii::t('app', 'Datos del pedido')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="mb-4">
                <?= $form->field($model, 'status_id')->widget(Select2::class, [
                    'data' => Status::labels(),
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'Seleccione un estado'),
                        'title' => Yii::t('app', 'Seleccione un estado'),
                    ],
                    'theme' => Select2::THEME_MATERIAL,
                    'pluginOptions' => [
                        'allowClear' => false,
                    ],
                ]); ?>
            </div>
            <div class="mb-4">
                <?= $form->field($model, 'user_id')->widget(Select2::class, [
                    'data' => User::labels(),
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'Seleccione un usuario'),
                        'title' => Yii::t('app', 'Seleccione un usuario'),
                    ],
                    'theme' => Select2::THEME_MATERIAL,
                    'pluginOptions' => [
                        'allowClear' => false,
                    ],
                ]); ?>
            </div>
            <div class="mb-4">
                <?= $form->field($model, 'dealer_id')->widget(Select2::class, [
                    'data' => User::dealers(),
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'Seleccione un repartidor'),
                        'title' => Yii::t('app', 'Seleccione un repartidor'),
                    ],
                    'theme' => Select2::THEME_MATERIAL,
                    'pluginOptions' => [
                        'allowClear' => false,
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <div class="form-group my-3">
        <?= Html::submitButton(
            Yii::t('app', $model->isNewRecord ?
                Yii::t('app', 'Crear pedido') :
                Yii::t('app', 'Editar pedido')),
            [
                'class' => 'btn btn-primary mt-3',
                'name' => 'dealer-form-button',
                'title' => Yii::t('app', 'Guardar cambios'),
            ]
        ); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>