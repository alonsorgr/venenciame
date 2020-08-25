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

$url = Url::to(['partners/states']);

$js = <<<EOT
$('#requestpartnersform-state_id').empty();
$('#requestpartnersform-country_id').on('change', function (ev) {
    var country = $(this);
    var country_id = country.val();
    if (country_id === '') {
        $('#requestpartnersform-state_id').empty();
        $('#requestpartnersform-state_id').append('<option value=""></option>');
        return;
    }
    $.ajax({
        method: 'GET',
        url: '$url',
        data: {
            id: country_id
        },
        success: function (data) {
            var states = $('#requestpartnersform-state_id');
            states.empty();
            states.append(`<option value=""></option>`);
            for (var i in data) {
                states.append(`<option value="\${i}">\${data[i]}</option>`);
            }
        }   
    });
});
EOT;
$this->registerJs($js);

?>
<div class="partners-request">
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
                    <?= $form->field($model, 'name')->textInput([
                        'maxlength' => true,
                        'placeholder' => Yii::t('app', 'Introduzca el combre de la empresa o bodega'),
                        'title' => Yii::t('app', 'Nombre'),
                    ]); ?>
                    <?= $form->field($model, 'country_id')->widget(Select2::class, [
                        'data' => Countries::labels(),
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => Yii::t('app', 'País de residencia fiscal'),
                            'title' => Yii::t('app', 'País de residencia fiscal'),
                        ],
                        'theme' => Select2::THEME_MATERIAL,
                        'pluginOptions' => [
                            'allowClear' => false,
                        ],
                    ]); ?>
                    <?= $form->field($model, 'state_id')->widget(Select2::class, [
                        'data' => States::labels(),
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => Yii::t('app', 'Estado o provincia de residencia fiscal'),
                            'title' => Yii::t('app', 'Estado o provincia de residencia fiscal'),
                        ],
                        'theme' => Select2::THEME_MATERIAL,
                        'pluginOptions' => [
                            'allowClear' => false,
                        ],
                    ]); ?>
                    <?= $form->field($model, 'address')->textInput([
                        'maxlength' => true,
                        'placeholder' => Yii::t('app', 'Introduzca la dirección física de la empresa o bodega'),
                        'title' => Yii::t('app', 'Introduzca la dirección física de la empresa o bodega'),
                    ]); ?>
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
                    <div class="form-group my-3">
                        <?= Html::submitButton(
                            Yii::t('app', Yii::t('app', 'Enviar')),
                            [
                                'class' => 'btn btn-primary mt-3',
                                'name' => 'partners-form-button',
                                'title' => Yii::t('app', 'Enviar'),
                            ]
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <?= $this->render('_sidebar'); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>