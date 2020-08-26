<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\RequestPartnersForm */

use app\helpers\Bootstrap;
use app\models\Countries;
use app\models\States;
use borales\extensions\phoneInput\PhoneInput;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Solicitud de socio');

$this->params['breadcrumbs'][] = $this->title;

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
            states.append(`<option value=""></option>`);
            for (var i in data) {
                states.append(`<option value="\${i}">\${data[i]}</option>`);
            }
        }   
    });
}

$('#request-state_id').empty();
$('#request-country_id').on('change', function (ev) {
    getStates($(this), '#request-state_id', '$url');
});

EOT;
$this->registerJs($js);

?>
<div class="partners-request">
    <?php if (Yii::$app->session->hasFlash('partnersFormSubmitted')) : ?>
        <?= Yii::$app->session->setFlash(
            'success',
            Yii::t('app', 'Gracias por contactar con nosotros, {username}. Nosotros responderemos a la mayor brevedad posible.', [
                'username' => $model->user->username === '' ?: Yii::t('app', 'invitado'),
            ])
        ); ?>
        <div class="row d-flex justify-content-center">
            <div class="col text-center">
                <div class="my-5">
                    <?= Html::img('@web/img/site/logo.svg', [
                        'class' => 'mt-1',
                        'width' => 256,
                        'title' => Yii::t('app', 'Imagen animada de copa de vino'),
                        'atl' => Yii::t('app', 'Imagen animada de copa de vino'),
                    ]); ?>
                </div>
                <?= Html::a(Yii::t('app', 'Ir a la página principal'), ['site/index'], [
                    'class' => 'btn btn-primary',
                    'title' => Yii::t('app', 'Ir a la página principal'),
                ]); ?>
            </div>
        </div>
    <?php else : ?>
        <?php $form = ActiveForm::begin([
            'id' => 'partners-request',
            'enableAjaxValidation' => true,
        ]); ?>
        <div class="row my-4 justify-content-between">
            <div class="col-xl-8">
                <div class="row display-5">
                    <div class="col mb-4">
                        <?= Yii::t('app', 'Solicitud de socio'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 mb-3">
                        <?= Bootstrap::header(Yii::t('app', 'Datos de su empresa o bodega')); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
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
                                    'id' => 'request-country_id',
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
                                    'id' => 'request-state_id',
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
                        <div class="form-group my-3">
                            <?= Html::submitButton(Yii::t('app', Yii::t('app', 'Enviar')), [
                                'class' => 'btn btn-primary mt-3',
                                'name' => 'partners-form-button',
                                'title' => Yii::t('app', 'Enviar'),
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 mr-2">
                <?= $this->render('_sidebar'); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
</div>