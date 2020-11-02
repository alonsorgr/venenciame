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
        <div class="col-xl-11">
            <?= $form->field($model, 'name')->textInput([
                'maxlength' => true,
                'placeholder' => Yii::t('app', 'Buscar por bodega'),
                'title' => Yii::t('app', 'Buscar por bodega'),
            ]); ?>
        </div>
        <div class="col-xl-1 d-flex justify-content-start justify-content-xl-end my-4">
            <?= Html::submitButton('<i class="fas fa-search mr"></i>', [
                'class' => 'btn btn-outline-primary btn-search',
                'placeholder' => Yii::t('app', 'Buscar'),
                'title' => Yii::t('app', 'Buscar'),
            ]); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>