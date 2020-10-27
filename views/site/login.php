<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Bootstrap;

$this->registerJsFile("@web/js/form.js", [
    'depends' => [
        \yii\web\JqueryAsset::class,
    ]
]);

$this->registerJs("passwordInput('login-password')");

$this->title = Yii::t('app', 'Iniciar sesión');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="container">
        <div class="row">
            <div class="col">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                ]); ?>
                <div class="row">
                    <div class="col">
                        <?= $form->field($model, 'login', [
                            'template' => Bootstrap::inputTemplate([
                                'image' => 'fas fa-user',
                            ]),
                        ])->textInput([
                            'class' => 'form-control',
                            'placeholder' => Yii::t('app', 'Introduzca su nombre de usuario o correo electrónico'),
                            'title' => Yii::t('app', 'Nombre de usuario o correo electrónico'),
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?= $form->field($model, 'password', [
                            'template' => Bootstrap::inputTemplate([
                                'image' => 'fas fa-key',
                                'type-password' => true,
                            ]),
                        ])->passwordInput([
                            'id' => 'login-password',
                            'class' => 'form-control password-input',
                            'placeholder' => Yii::t('app', 'Escriba su contraseña'),
                            'title' => Yii::t('app', 'Contraseña de acceso'),
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?= $form->field($model, 'rememberMe',)->checkbox([
                            'class' => 'custom-control-input',
                            'title' => Yii::t('app', 'Mantener la sesión iniciada'),
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?= Html::submitButton(Yii::t('app', 'Iniciar sesión'), [
                            'name' => 'login-button',
                            'class' => 'btn btn-primary btn-block font-weight-bold',
                            'title' => Yii::t('app', 'Inicia sesión en el sitio'),
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="horizontal-divider"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <?= Html::a(Yii::t('app', '¿Olvidó su contraseña?'), Url::to(['site/request-password']), [
                            'title' => Yii::t('app', 'Recuperar contraseña de acceso.'),
                        ]); ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>