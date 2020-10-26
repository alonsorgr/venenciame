<?php

use app\helpers\Bootstrap;
use app\models\Categories;
use app\models\Denominations;
use app\models\Partners;
use app\models\Statuses;
use app\models\User;
use app\models\Vats;
use kartik\file\FileInput;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="articles-form">

    <?php $form = ActiveForm::begin([
        'id' => 'user-form',
        'enableAjaxValidation' => true,
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <div class="row">
        <div class="col-xl-12 mb-3">
            <?= Bootstrap::header(Yii::t('app', 'Datos generales')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="mb-4">
                <?= $form->field($model, 'title')->textInput([
                    'maxlength' => true,
                    'placeholder' => Yii::t('app', 'Escriba el nombre del artículo de vino'),
                    'title' => Yii::t('app', 'Escriba el nombre del artículo de vino'),
                ]); ?>
            </div>
            <div class="mb-4">
                <?= $form->field($model, 'description')->textInput([
                    'maxlength' => true,
                    'placeholder' => Yii::t('app', 'Escriba una descripción del artículo de vino'),
                    'title' => Yii::t('app', 'Escriba una descripción del artículo de vino'),
                ]); ?>
            </div>
            <?php if (User::isAdmin()) : ?>
                <div class="mb-4">
                    <?= $form->field($model, 'partner_id')->widget(Select2::class, [
                        'data' => Partners::labels(),
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => Yii::t('app', 'Seleccione una bodega'),
                            'title' => Yii::t('app', 'Seleccione una bodega'),
                        ],
                        'theme' => Select2::THEME_MATERIAL,
                        'pluginOptions' => [
                            'allowClear' => false,
                        ],
                    ]); ?>
                </div>
            <?php else : ?>
                <div class="col">
                    <?= $form->field($model, 'partner_id')->hiddenInput([
                        'value' => User::partnerId(),
                    ])->label(false); ?>
                </div>
            <?php endif ?>
            <div class="col">
                <?= $form->field($model, 'partner_id')->hiddenInput([
                    'value' => User::partnerId(),
                ])->label(false); ?>
            </div>

            <div class="mb-4">
                <?= $form->field($model, 'category_id')->widget(Select2::class, [
                    'data' => Categories::labels(),
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'Seleccione una categoría o tipo de vino'),
                        'title' => Yii::t('app', 'Seleccione una categoría o tipo de vino'),
                    ],
                    'theme' => Select2::THEME_MATERIAL,
                    'pluginOptions' => [
                        'allowClear' => false,
                    ],
                ]); ?>
            </div>
            <div class="mb-4">
                <?= $form->field($model, 'denomination_id')->widget(Select2::class, [
                    'data' => Denominations::labels(),
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'Seleccione una denominación de origen'),
                        'title' => Yii::t('app', 'Seleccione una denominación de origen'),
                    ],
                    'theme' => Select2::THEME_MATERIAL,
                    'pluginOptions' => [
                        'allowClear' => false,
                    ],
                ]); ?>
            </div>
            <div class="mb-4">
                <?= $form->field($model, 'vat_id')->widget(Select2::class, [
                    'data' => Vats::labels(),
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'Seleccione un tipo de IVA'),
                        'title' => Yii::t('app', 'Seleccione un tipo de IVA'),
                    ],
                    'theme' => Select2::THEME_MATERIAL,
                    'pluginOptions' => [
                        'allowClear' => false,
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 mb-3 mt-5">
            <?= Bootstrap::header(Yii::t('app', 'Precio y Stock')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="mb-4">
                <?= $form->field($model, 'price')->widget(NumberControl::class, [
                    'maskedInputOptions' => [
                        'suffix' => '€ ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'rightAlign' => false
                    ],
                    'displayOptions' =>  [
                        'placeholder' => Yii::t('app', 'Seleccione el precio sin IVA del artículo'),
                    ],
                ]); ?>
            </div>
            <div class="mb-4">
                <?= $form->field($model, 'stock')->widget(NumberControl::class, [
                    'maskedInputOptions' => [
                        'suffix' => 'uds. ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'rightAlign' => false
                    ],
                    'displayOptions' =>  [
                        'placeholder' => Yii::t('app', 'Introduzca el número de artículos disponibles en stock'),
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 mb-3 mt-5">
            <?= Bootstrap::header(Yii::t('app', 'Ficha técnica')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="mb-4">
                <?= $form->field($model, 'degrees')->widget(NumberControl::class, [
                    'maskedInputOptions' => [
                        'suffix' => '% ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'rightAlign' => false
                    ],
                    'displayOptions' =>  [
                        'placeholder' => Yii::t('app', 'Introduzca la graduación alcohólica del artículo'),
                    ],
                ]); ?>
            </div>
            <div class="mb-4">
                <?= $form->field($model, 'capacity')->widget(NumberControl::class, [
                    'maskedInputOptions' => [
                        'suffix' => 'cl. ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'rightAlign' => false
                    ],
                    'displayOptions' =>  [
                        'placeholder' => Yii::t('app', 'Introduzca la capacidad de la botella'),
                    ],
                ]); ?>
            </div>
            <div class="mb-4">
                <?= $form->field($model, 'variety')->textInput([
                    'maxlength' => true,
                    'placeholder' => Yii::t('app', 'Introduzca la variedad del vino'),
                    'title' => Yii::t('app', 'Introduzca la variedad del vino'),
                ]); ?>
            </div>
            <div class="mb-4">
                <?= $form->field($model, 'pairing')->textInput([
                    'maxlength' => true,
                    'placeholder' => Yii::t('app', 'Introduzca el marinado que le conviene al artículo'),
                    'title' => Yii::t('app', 'Introduzca el marinado que le conviene al artículo'),
                ]); ?>
            </div>
            <div class="mb-4">
                <?= $form->field($model, 'review')->textarea([
                    'maxlength' => true,
                    'rows' => '8',
                    'placeholder' => Yii::t('app', 'Introduzca la opinión personal o de un experto'),
                    'title' => Yii::t('app', 'Introduzca la opinión personal o de un experto'),
                ]); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 mb-3 mt-5">
            <?= Bootstrap::header(Yii::t('app', 'Imagen del artículo')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <?= $form->field($model, 'upload')->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                ],
                'pluginOptions' => [
                    'showUpload' => false,
                    'showRemove' => false,
                    'initialPreview' => [
                        Url::base(true) . '/' . $model->link,
                    ],
                    'initialPreviewAsData' => true,
                    'initialCaption' => Html::encode($model->title),
                    'initialPreviewConfig' => [
                        ['caption' => Html::encode($model->title)],
                    ],
                    'overwriteInitial' => true,
                    'maxFileSize' => 5000,
                    'mainClass' => 'input-group-sm mt-4'
                ]
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 mb-3 mt-5">
            <?= Bootstrap::header(Yii::t('app', 'Opciones')); ?>
        </div>
    </div>
    <?php if ($model->isNewRecord || User::isAdmin()) : ?>
        <div class="row">
            <div class="col-xl-6">
                <?= $form->field($model, 'status_id')->widget(Select2::class, [
                    'data' => Statuses::labels(),
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'Estado de la publicación del artículo'),
                        'title' => Yii::t('app', 'Estado de la publicación del artículo'),
                    ],
                    'theme' => Select2::THEME_MATERIAL,
                    'pluginOptions' => [
                        'allowClear' => false,
                    ],
                ]); ?>
            </div>
        </div>
    <?php endif ?>
    <div class="form-group my-5">
        <?= Html::submitButton(
            Yii::t('app', $model->isNewRecord ?
                Yii::t('app', 'Crear artículo') :
                Yii::t('app', 'Guardar cambios')),
            [
                'class' => 'btn btn-primary mt-3',
                'name' => 'user-form-button',
                'title' => Yii::t('app', 'Guardar cambios'),
            ]
        ); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>