<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap4\Html;
use app\helpers\Bootstrap;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
use app\models\Languages;
use app\models\Roles;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\bootstrap4\ActiveForm */

$this->registerJsFile("@web/js/form.js", [
    'depends' => [
        \yii\web\JqueryAsset::class,
    ]
]);

$this->registerJs("passwordInput('reset-password')");

?>

<div class="user-form">
    <?php $form = ActiveForm::begin([
        'id' => 'user-form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::to(['user/validation']),
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>
    <div class="row">
        <div class="col-xl-12 mb-3">
            <?= Bootstrap::header(Yii::t('app', 'Datos Personales')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <?= $form->field($model, 'username')->textInput([
                'maxlength' => true,
                'placeholder' => Yii::t('app', 'Escriba su nombre de usuario'),
                'title' => Yii::t('app', 'Nombre de usuario'),
            ]); ?>
            <?= $form->field($model, 'email')->textInput([
                'maxlength' => true,
                'placeholder' => Yii::t('app', 'Escriba su dirección de correo electrónico'),
                'title' => Yii::t('app', 'Dirección de correo electrónico'),
            ]); ?>
            <?= $form->field($model, 'name')->textInput([
                'maxlength' => true,
                'placeholder' => Yii::t('app', 'Escriba su nombre'),
                'title' => Yii::t('app', 'Nombre'),
            ]); ?>
            <?= $form->field($model, 'surname')->textInput([
                'maxlength' => true,
                'placeholder' => Yii::t('app', 'Escriba su primer apellido'),
                'title' => Yii::t('app', 'Primer apellido'),
            ]); ?>
            <?= $form->field($model, 'birthdate')->widget(DateControl::class, [
                'widgetOptions' => [
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'autoclose' => true,
                    ],
                ],
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 mb-3 mt-5">
            <?= Bootstrap::header(Yii::t('app', 'Imagen de perfil')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <?= $form->field($model, 'image')->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                ],
                'pluginOptions' => [
                    'showUpload' => false,
                    'initialPreview' => [
                        '',
                    ],
                    'initialPreviewAsData' => true,
                    'initialCaption' => Html::encode($model->username),
                    'initialPreviewConfig' => [
                        ['caption' => Html::encode($model->username)],
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
            <?= Bootstrap::header(Yii::t('app', 'Seguridad')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <?= $form->field($model, 'password', [
                'template' => Bootstrap::inputTemplate([
                    'type-password' => true,
                ]),
            ])->passwordInput([
                'id' => 'reset-password',
                'class' => 'form-control password-input default-input',
                'placeholder' => Yii::t('app', 'Escriba su nueva contraseña'),
                'title' => Yii::t('app', 'Contraseña de acceso'),
                'value' => '',
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 mb-3 mt-5">
            <?= Bootstrap::header(Yii::t('app', 'Aplicación')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <?= $form->field($model, 'language_id')->widget(Select2::class, [
                'data' => Languages::labels(),
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => Yii::t('app', 'Lenguaje de la aplicación'),
                    'title' => Yii::t('app', 'Lenguaje de la aplicación'),
                ],
                'theme' => Select2::THEME_MATERIAL,
                'pluginOptions' => [
                    'allowClear' => false,
                ],
            ]); ?>
        </div>
    </div>
    <?php if ($model->isNewRecord || Yii::$app->user->identity->admin) : ?>
        <div class="row">
            <div class="col-xl-6">
                <?= $form->field($model, 'rol_id')->widget(Select2::class, [
                    'data' => Roles::labels(),
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'Rol del usuario en la aplicación'),
                        'title' => Yii::t('app', 'Rol del usuario en la aplicación'),
                    ],
                    'theme' => Select2::THEME_MATERIAL,
                    'pluginOptions' => [
                        'allowClear' => false,
                    ],
                ]); ?>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-xl-6">
                <?= $form->field($model, 'admin',)->checkbox([
                    'class' => 'custom-control-input',
                    'title' => Yii::t('app', 'Usuario administrador'),
                ]); ?>
            </div>
        </div>
    <?php endif ?>
    <div class="form-group my-5">
        <?= Html::submitButton(
            Yii::t('app', $model->isNewRecord ?
                Yii::t('app', 'Crear usuario') :
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