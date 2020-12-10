<?php

use app\models\Status;
use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\ArticlesSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-12 col-md-2">
            <?= $form->field($model, 'user.username')->textInput([
                'maxlength' => true,
                'placeholder' => Yii::t('app', 'Buscar por nombre de usuario'),
                'title' => Yii::t('app', 'Nombre del artículo'),
            ]); ?>
        </div>
        <div class="col-12 col-md-2">
            <?= $form->field($model, 'partner.name')->textInput([
                'maxlength' => true,
                'placeholder' => Yii::t('app', 'Buscar por socio'),
                'title' => Yii::t('app', 'Socio'),
            ]); ?>
        </div>
        <div class="col-12 col-md-2">
            <?= $form->field($model, 'total_price')->textInput([
                'maxlength' => true,
                'placeholder' => Yii::t('app', 'Buscar capacidad'),
                'title' => Yii::t('app', 'Capacidad'),
            ]); ?>
        </div>
        <div class="col-12 col-md-2">
            <?= $form->field($model, 'status_id')->widget(Select2::class, [
                'data' => Status::labels(),
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => Yii::t('app', 'Buscar por estado'),
                    'title' => Yii::t('app', 'Estado'),
                ],
                'theme' => Select2::THEME_MATERIAL,
                'pluginOptions' => [
                    'allowClear' => false,
                ],
            ]); ?>
        </div>
        <div class="col-12 col-md-2">
            <?= $form->field($model, 'created_at')->widget(DateControl::class, [
                'widgetOptions' => [
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'autoclose' => true,
                    ],
                    'options' => [
                        'placeholder' => Yii::t('app', 'Buscar por fecha'),
                    ]
                ],
            ]); ?>
        </div>
        <div class="col-12 col-md-2 my-4">
            <?= Html::submitButton('<i class="fas fa-search mr-2"></i>' . Yii::t('app', 'Buscar'), [
                'class' => 'btn btn-outline-primary btn-block',
                'placeholder' => Yii::t('app', 'Buscar'),
                'title' => Yii::t('app', 'Buscar'),
            ]); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>