<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\RequestPartnersForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap4\Html;
use app\helpers\Bootstrap;
use borales\extensions\phoneInput\PhoneInput;
use kartik\select2\Select2;
use kartik\file\FileInput;
use app\models\User;
use app\models\Countries;
use app\models\States;
use app\models\Statuses;

$url = Url::to(['states/states']);

$js = <<<EOT

function getStates(country, state, url) {
    var country_id = country.val();
    if (country_id === '') {
        $(state).empty();
        $(state).append('<option value=""></option>');
        return;
    }
    $.ajax({
        method: 'GET',
        url: url,
        data: {
            id: country_id
        },
        success: function (data) {
            var states = $(state);
            states.empty();
            for (var i in data) {
                states.append(`<option value="\${i}">\${data[i]}</option>`);
            }
        }   
    });
}
$('#form-country_id').on('change', function (ev) {
    getStates($(this), '#form-state_id', '$url');
});
EOT;
$this->registerJs($js);

$js = <<<EOT
getStates($('#form-country_id'), '#form-state_id', '$url');
EOT;

$this->registerJs($js);


?>
<div class="partners-form">
    <?php $form = ActiveForm::begin([
        'id' => 'partners-form',
        'enableAjaxValidation' => true,
    ]); ?>
    <div class="row my-4 justify-content-between">
        <div class="col-xl-8">
            <div class="row display-5">
                <div class="col mb-4">
                    <?= $model->isNewRecord ? Yii::t('app', 'Dar de alta') : Yii::t('app', 'Editar'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 mb-3">
                    <?= Bootstrap::header(Yii::t('app', 'Datos de su empresa o bodega')); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <?php if ($model->isNewRecord) : ?>
                        <div class="mb-4">
                            <?= $form->field($model, 'user_id')->widget(Select2::class, [
                                'data' => User::labels(),
                                'options' => [
                                    'class' => 'form-control',
                                    'placeholder' => Yii::t('app', 'Seleccione el usuario vinculado a este socio'),
                                    'title' => Yii::t('app', 'Seleccione el usuario vinculado a este socio'),
                                ],
                                'theme' => Select2::THEME_MATERIAL,
                                'pluginOptions' => [
                                    'allowClear' => false,
                                ],
                            ]); ?>
                        </div>
                    <?php endif; ?>
                    <div class="mb-4">
                        <?= $form->field($model, 'name')->textInput([
                            'maxlength' => true,
                            'placeholder' => Yii::t('app', 'Introduzca el combre de la empresa o bodega'),
                            'title' => Yii::t('app', 'Nombre'),
                        ]); ?>
                    </div>
                    <div class="mb-4">
                        <?= $form->field($model, 'country_id')->widget(Select2::class, [
                            'data' => Countries::labels(),
                            'options' => [
                                'id' => 'form-country_id',
                                'class' => 'form-control',
                                'placeholder' => Yii::t('app', 'País de residencia fiscal'),
                                'title' => Yii::t('app', 'País de residencia fiscal'),
                            ],
                            'theme' => Select2::THEME_MATERIAL,
                            'pluginOptions' => [
                                'allowClear' => false,
                            ],
                        ]); ?>
                    </div>
                    <div class="mb-4">
                        <?= $form->field($model, 'state_id')->widget(Select2::class, [
                            'data' => States::labels(),
                            'options' => [
                                'id' => 'form-state_id',
                                'class' => 'form-control',
                                'placeholder' => Yii::t('app', 'Estado o provincia de residencia fiscal'),
                                'title' => Yii::t('app', 'Estado o provincia de residencia fiscal'),
                            ],
                            'theme' => Select2::THEME_MATERIAL,
                            'pluginOptions' => [
                                'allowClear' => false,
                            ],
                        ]); ?>
                    </div>
                    <div class="mb-4">
                        <?= $form->field($model, 'city')->textInput([
                            'maxlength' => true,
                            'placeholder' => Yii::t('app', 'Introduzca la localidad de su empresa'),
                            'title' => Yii::t('app', 'Introduzca la localidad de su empresa'),
                        ]); ?>
                    </div>
                    <div class="mb-4">
                        <?= $form->field($model, 'zip_code')->textInput([
                            'maxlength' => true,
                            'placeholder' => Yii::t('app', 'Introduzca el código postal'),
                            'title' => Yii::t('app', 'Introduzca el código postal'),
                        ]); ?>
                    </div>
                    <div class="mb-4">
                        <?= $form->field($model, 'address')->textInput([
                            'maxlength' => true,
                            'placeholder' => Yii::t('app', 'Introduzca la dirección física de la empresa o bodega'),
                            'title' => Yii::t('app', 'Introduzca la dirección física de la empresa o bodega'),
                        ]); ?>
                    </div>
                    <div class="mb-4">
                        <div class="form-group">
                            <label for="phone"><?= Yii::t('app', 'Número de teléfono') ?></label>
                            <?= $form->field($model, 'phone')->widget(PhoneInput::class, [
                                'options' => [
                                    'class' => 'form-control',
                                    'placeholder' => Yii::t('app', 'Introduzca número de teléfono...'),
                                    'title' => Yii::t('app', 'Número de teléfono'),
                                    'maxlength' => true,
                                ],
                                'jsOptions' => [
                                    'preferredCountries' => ['es', 'en', 'us'],
                                ]
                            ])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-xl-12 mb-3">
                    <?= Bootstrap::header(Yii::t('app', 'Información adicional de su empresa o bodega')); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="mb-4">
                        <?= $form->field($model, 'description')->textInput([
                            'maxlength' => true,
                            'placeholder' => Yii::t('app', 'Introduzca una breve descripción de su empresa o bodega'),
                            'title' => Yii::t('app', 'Introduzca una breve descripción de su empresa o bodega'),
                        ]); ?>
                    </div>
                    <div class="mb-4">
                        <?= $form->field($model, 'information')->textarea([
                            'rows' => 6,
                            'maxlength' => true,
                            'placeholder' => Yii::t('app', 'Introduzca una introducción breve'),
                            'title' => Yii::t('app', 'Introduzca una introducción breve'),
                        ]); ?>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-xl-12 mb-3">
                    <?= Bootstrap::header(Yii::t('app', 'Logo corporativo')); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="mb-4">
                        <?= $form->field($model, 'upload')->widget(FileInput::class, [
                            'options' => [
                                'accept' => 'image/*',
                            ],
                            'pluginOptions' => [
                                'showUpload' => false,
                                'showRemove' => false,
                                'initialPreview' => [
                                    $model->link,
                                ],
                                'initialPreviewAsData' => true,
                                'initialCaption' => Html::encode($model->name),
                                'initialPreviewConfig' => [
                                    ['caption' => Html::encode($model->name)],
                                ],
                                'overwriteInitial' => true,
                                'maxFileSize' => 5000,
                                'mainClass' => 'input-group-sm mt-4'
                            ]
                        ]); ?>
                    </div>
                </div>
            </div>
            <?php if ($model->isNewRecord || Yii::$app->user->identity->admin) : ?>
                <div class="row mt-3">
                    <div class="col-xl-12 mb-3">
                        <?= Bootstrap::header(Yii::t('app', 'Administrar')); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="mb-4">
                            <?= $form->field($model, 'status_id')->widget(Select2::class, [
                                'data' => Statuses::labels(),
                                'options' => [
                                    'class' => 'form-control',
                                    'placeholder' => Yii::t('app', 'Estado de la cuenta'),
                                    'title' => Yii::t('app', 'Estado de la cuenta'),
                                ],
                                'theme' => Select2::THEME_MATERIAL,
                                'pluginOptions' => [
                                    'allowClear' => false,
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <div class="form-group my-3">
                <?= Html::submitButton(Yii::t('app', Yii::t('app', 'Enviar')), [
                    'class' => 'btn btn-primary mt-3',
                    'name' => 'partners-form-button',
                    'title' => Yii::t('app', 'Enviar'),
                ]); ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="col-xl-3 mr-2">
            <?= $this->render('_sidebar'); ?>
        </div>
    </div>
</div>