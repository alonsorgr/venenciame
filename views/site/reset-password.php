<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\ResetPasswordForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\helpers\Bootstrap;

$this->registerJsFile("@web/js/form.js", [
    'depends' => [
        \yii\web\JqueryAsset::class,
    ]
]);

$this->registerJs("passwordInput('reset-password')");
$this->registerJs("passwordInput('confirm-password')");

$this->title = Yii::t('app', 'Crear nueva contraseña');

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-reset-password">
    <div class="container-fluid mt-0 mt-sm-0 mt-md-5">
        <div class="row flex-wrap flex-lg-nowrap justify-content-center">
            <div class="col-12 col-sm-12 col-md-12 col-lg-5">
                <div class="card">
                    <div class="card-header lead p-4">
                        <?= Yii::t('app', 'Cree una nueva contrseaña') ?>
                    </div>
                    <div class="card-body m-2">
                        <?php $form = ActiveForm::begin([
                            'id' => 'reset-password-form',
                            'enableAjaxValidation' => true,
                        ]); ?>
                        <div class="row">
                            <div class="col">
                                <?= $form->field($model, 'password', [
                                    'template' => Bootstrap::inputTemplate([
                                        'image' => 'fas fa-key',
                                        'type-password' => true,
                                    ]),
                                ])->passwordInput([
                                    'id' => 'reset-password',
                                    'class' => 'form-control password-input',
                                    'placeholder' => Yii::t('app', 'Escriba su nueva contraseña'),
                                    'title' => Yii::t('app', 'Contraseña de acceso'),
                                ]); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?= Html::submitButton('Restablecer contraseña', [
                                    'name' => 'reset-button',
                                    'class' => 'btn btn-primary btn-block font-weight-bold',
                                    'title' => Yii::t('app', 'Restablecerer contraseña'),
                                ]); ?>
                            </div>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 'passwordRepeat' => Yii::t('app', 'Repita la contraseña'),