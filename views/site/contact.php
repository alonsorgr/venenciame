<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('app', 'Contacto');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')) : ?>
        <?= Yii::$app->session->setFlash(
            'success',
            Yii::t('app', 'Gracias por contactar con nosotros, {username}. Nosotros responderemos a la mayor brevedad posible.', [
                'username' => $model->name,
            ])
        ); ?>
        <div class="row d-flex justify-content-center">
            <div class="col text-center">
                <div class="my-5">
                    <?= Html::img('@web/img/site/logo.svg', [
                        'class' => 'mt-1',
                        'width' => 256,
                        'title' => Yii::t('app', 'Imagen animada de copa de vino'),
                        'atl' => Yii::t('app', 'Imagen animada de copa de vino'),
                    ]); ?>
                </div>
                <?= Html::a(Yii::t('app', 'Ir a la página principal'), ['site/index'], [
                    'class' => 'btn btn-primary',
                    'title' => Yii::t('app', 'Ir a la página principal'),
                ]); ?>
            </div>
        </div>
    <?php else : ?>
        <div class="row my-4 justify-content-between">
            <div class="col-xl-6">
                <div class="row display-4">
                    <div class="col">
                        <?= Yii::t('app', 'Contacta con {appname}', [
                            'appname' => Yii::$app->name,
                        ]); ?>
                        <div class="lead my-4">
                            <?= Yii::t('app', 'Si tiene consultas comerciales u otras preguntas, complete el siguiente formulario para comunicarse con nosotros.'); ?>
                        </div>
                    </div>
                </div>
                <?php $form = ActiveForm::begin([
                    'id' => 'contact-form',
                ]); ?>
                <?= $form->field($model, 'name')->textInput([
                    'maxlength' => true,
                    'placeholder' => Yii::t('app', 'Introduzca su nombre completo'),
                    'title' => Yii::t('app', 'Introduzca su nombre completo'),
                ]); ?>
                <?= $form->field($model, 'email')->textInput([
                    'maxlength' => true,
                    'placeholder' => Yii::t('app', 'Introduzca su dirección de correo electrónico'),
                    'title' => Yii::t('app', 'Introduzca su dirección de correo electrónico'),
                ]); ?>
                <?= $form->field($model, 'subject')->textInput([
                    'maxlength' => true,
                    'placeholder' => Yii::t('app', 'Introduzca el asunto de su mensaje'),
                    'title' => Yii::t('app', 'Introduzca el asunto de su mensaje'),
                ]); ?>
                <?= $form->field($model, 'body')->textarea([
                    'maxlength' => true,
                    'rows' => 5,
                    'placeholder' => Yii::t('app', 'Introduzca el contenido de su mensaje'),
                    'title' => Yii::t('app', 'Introduzca el contenido de su mensaje'),
                ]); ?>
                <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                    'imageOptions' => [
                        'class' => 'col-sm-3',
                        'style' => 'padding: 0'
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => Yii::t('app', 'Introduzca el texto de la imagen superior'),
                        'title' => Yii::t('app', 'Introduzca el texto de la imagen superior'),
                    ],
                ]); ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Enviar'), [
                        'class' => 'btn btn-primary mt-3',
                        'name' => 'contact-button',
                        'title' => Yii::t('app', 'IEnviar el formulario'),
                    ]); ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-xl-3">
                <?= $this->render('_aside'); ?>
            </div>
        </div>
    <?php endif; ?>
</div>