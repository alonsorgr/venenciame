<?php

use app\models\Countries;
use app\models\States;
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
    <div class="row">
        <div class="card w-100">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'options' => [
                    'data-pjax' => 1
                ],
            ]); ?>
            <div class="card-header">
                <div class="lead"><?= Yii::t('app', 'Buscar') ?></div>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <?= $form->field($model, 'name')->textInput([
                        'maxlength' => true,
                        'placeholder' => Yii::t('app', 'Buscar por nombre de la empresa o bodega'),
                        'title' => Yii::t('app', 'Buscar por nombre de la empresa o bodega'),
                    ]); ?>
                </div>
                <div class="mb-4">
                    <?= $form->field($model, 'city')->textInput([
                        'maxlength' => true,
                        'placeholder' => Yii::t('app', 'Buscar por localidad de su empresa'),
                        'title' => Yii::t('app', 'Buscar por localidad de su empresa'),
                    ]); ?>
                </div>
                <div class="mb-4">
                    <?= $form->field($model, 'country_id')->widget(Select2::class, [
                        'data' => Countries::labels(),
                        'options' => [
                            'id' => 'form-country_id',
                            'class' => 'form-control',
                            'placeholder' => Yii::t('app', 'Buscar por país de residencia fiscal'),
                            'title' => Yii::t('app', 'Buscar por país de residencia fiscal'),
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
                            'placeholder' => Yii::t('app', 'Buscar por estado o provincia de residencia fiscal'),
                            'title' => Yii::t('app', 'Buscar por estado o provincia de residencia fiscal'),
                        ],
                        'theme' => Select2::THEME_MATERIAL,
                        'pluginOptions' => [
                            'allowClear' => false,
                        ],
                    ]); ?>
                </div>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Buscar'), [
                        'class' => 'btn btn-primary btn-block'
                    ]) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>