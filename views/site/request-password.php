<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RequestPasswordForm */

use app\helpers\Bootstrap;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = Yii::t('app', 'Recuperar contraseña');

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-request-password">
    <div class="container-fluid mt-0 mt-sm-0 mt-md-5">
        <div class="row flex-wrap flex-lg-nowrap justify-content-center">
            <div class="col-12 col-sm-12 col-md-12 col-lg-5">
                <div class="card">
                    <h5 class="card-header lead p-4"><?= Yii::t('app', 'Recupere su contraseña') ?></h5>
                    <div class="card-body m-2">
                        <?php $form = ActiveForm::begin([
                            'id' => 'request-password',
                            'enableAjaxValidation' => true,
                        ]) ?>
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
                                <?= Html::submitButton('Recuperar contraseña', [
                                    'name' => 'request-button',
                                    'class' => 'btn btn-primary btn-block font-weight-bold',
                                    'title' => Yii::t('app', 'Enviar correo electrónico'),
                                ]); ?>
                            </div>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>