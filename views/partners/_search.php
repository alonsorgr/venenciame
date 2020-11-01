<?php

use app\models\Countries;
use app\models\States;
use app\models\Status;
use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\search\PartnersSearch */
/* @var $form yii\bootstrap4\ActiveForm */

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

<div class="partners-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row justify-content-between">
        <div class="col-12 col-md-3">
            <?= $form->field($model, 'name')->textInput([
                'maxlength' => true,
                'placeholder' => Yii::t('app', 'Buscar por nombre'),
                'title' => Yii::t('app', 'Buscar por nombre'),
            ]); ?>
        </div>
        <div class="col-12 col-md-3">
            <?= $form->field($model, 'country_id')->widget(Select2::class, [
                'data' => Countries::labels(),
                'options' => [
                    'id' => 'form-country_id',
                    'class' => 'form-control',
                    'placeholder' => Yii::t('app', 'Buscar por país'),
                    'title' => Yii::t('app', 'Buscar por país'),
                ],
                'theme' => Select2::THEME_MATERIAL,
                'pluginOptions' => [
                    'allowClear' => false,
                ],
            ]); ?>
        </div>
        <div class="col-12 col-md-3">
            <?= $form->field($model, 'state_id')->widget(Select2::class, [
                'data' => States::labels(),
                'options' => [
                    'id' => 'form-state_id',
                    'class' => 'form-control',
                    'placeholder' => Yii::t('app', 'Buscar por provincia'),
                    'title' => Yii::t('app', 'Buscar por provincia'),
                ],
                'theme' => Select2::THEME_MATERIAL,
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>
        </div>
        <div class="col-12 col-md-3 my-4">
            <?= Html::submitButton('<i class="fas fa-search mr-2"></i>' . Yii::t('app', 'Buscar'), [
                'class' => 'btn btn-outline-primary btn-block',
                'placeholder' => Yii::t('app', 'Buscar'),
                'title' => Yii::t('app', 'Buscar'),
            ]); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>