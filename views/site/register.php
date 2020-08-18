<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\RegisterForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use app\helpers\Bootstrap;

Modal::begin([
    'id' => 'privacity-modal',
    'title' => Yii::t('app', 'Política de privacidad'),
    'size' => 'modal-lg'
]);
echo $this->render('_privacity');
Modal::end();

Bootstrap::registerTooltip($this);

$this->registerJsFile("@web/js/form.js", [
    'depends' => [
        \yii\web\JqueryAsset::class,
    ]
]);

$this->registerJs("passwordInput('register-password')");

$this->title = Yii::t('app', 'Iniciar sesión');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
    <div class="container">
        <div class="row">
            <div class="col">
                <?php $form = ActiveForm::begin([
                    'id' => 'register-form',
                    'enableAjaxValidation' => true,
                ]); ?>
                <div class="row">
                    <div class="col">
                        <?= $form->field($model, 'username', [
                            'template' => Bootstrap::inputTemplate([
                                'image' => 'fas fa-user',
                            ]),
                        ])->textInput([
                            'class' => 'form-control',
                            'placeholder' => Yii::t('app', 'Introduzca su nombre de usuario'),
                            'title' => Yii::t('app', 'Nombre de usuario'),
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?= $form->field($model, 'email', [
                            'template' => Bootstrap::inputTemplate([
                                'image' => 'fas fa-envelope',
                            ]),
                        ])->textInput([
                            'class' => 'form-control',
                            'placeholder' => Yii::t('app', 'Introduzca su correo electrónico'),
                            'title' => Yii::t('app', 'Correo electrónico'),
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
                            'id' => 'register-password',
                            'class' => 'form-control password-input',
                            'placeholder' => Yii::t('app', 'Escriba su contraseña'),
                            'title' => Yii::t('app', 'Contraseña de acceso'),
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?= $form->field($model, 'privacity',)->checkbox([
                            'class' => 'custom-control-input',
                            'title' => Yii::t('app', 'Política de privacidad'),
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?= Html::submitButton(Yii::t('app', 'Registrarse'), [
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
                    <div class="col text-center mb-2">
                        <?= Html::a('<i class="fas fa-user-secret mr-2"></i>' . Yii::t('app', 'Política de privacidad'), 'privacity', [
                            'title' => Yii::t('app', 'Leer la política de privacidad.'),
                            'data-toggle' => 'modal',
                            'data-target' => '#privacity-modal',
                        ]) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>