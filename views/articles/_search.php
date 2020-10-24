<?php

use app\models\Categories;
use app\models\Partners;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\ArticlesSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="articles-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col p-0">
            <div class="mb-2">
                <?= $form->field($model, 'title')->textInput([
                    'maxlength' => true,
                    'placeholder' => Yii::t('app', 'Buscar por nombre'),
                    'title' => Yii::t('app', 'Buscar por nombre'),
                ]); ?>
            </div>
            <div class="mb-2">
                <?= $form->field($model, 'partner_id')->widget(Select2::class, [
                    'data' => Partners::labels(),
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'Buscar por bodega'),
                        'title' => Yii::t('app', 'Buscar por bodega'),
                    ],
                    'theme' => Select2::THEME_MATERIAL,
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]); ?>
            </div>
            <div class="mb-2">
                <?= $form->field($model, 'category_id')->widget(Select2::class, [
                    'data' => Categories::labels(),
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'Buscar por tipo de vino'),
                        'title' => Yii::t('app', 'Buscar por tipo de vino'),
                    ],
                    'theme' => Select2::THEME_MATERIAL,
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]); ?>
            </div>
            <div class="mb-2">
                <?= $form->field($model, 'denomination_id')->widget(Select2::class, [
                    'data' => Categories::labels(),
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'Buscar por denominación'),
                        'title' => Yii::t('app', 'Buscar por denominación'),
                    ],
                    'theme' => Select2::THEME_MATERIAL,
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]); ?>
            </div>
            <div class="mb-2">
                <?= $form->field($model, 'price')->widget(NumberControl::class, [
                    'maskedInputOptions' => [
                        'suffix' => '€ ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'rightAlign' => false
                    ],
                    'displayOptions' =>  [
                        'placeholder' => Yii::t('app', 'Buscar por precio'),
                    ],
                ]); ?>
            </div>
            <div class="mb-2">
                <?= $form->field($model, 'degrees')->widget(NumberControl::class, [
                    'maskedInputOptions' => [
                        'suffix' => '% ',
                        'groupSeparator' => '.',
                        'radixPoint' => ',',
                        'rightAlign' => false
                    ],
                    'displayOptions' =>  [
                        'placeholder' => Yii::t('app', 'Buscar por precio'),
                    ],
                ]); ?>
            </div>
            <div class="mb-2">
                <?= $form->field($model, 'variety')->textInput([
                    'maxlength' => true,
                    'placeholder' => Yii::t('app', 'Buscar por variedad'),
                    'title' => Yii::t('app', 'Buscar por variedad'),
                ]); ?>
            </div>
            <div class="mb-4">
                <?= $form->field($model, 'pairing')->textInput([
                    'maxlength' => true,
                    'placeholder' => Yii::t('app', 'Buscar por maridaje'),
                    'title' => Yii::t('app', 'Buscar por maridaje'),
                ]); ?>
            </div>
            <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-outline-primary btn-block']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>