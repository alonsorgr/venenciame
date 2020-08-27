<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Partners */

$this->title = Yii::t('app', 'Solicitud de socios');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Socios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partners-request">
    <?php if (Yii::$app->session->hasFlash('partnersFormSubmitted')) : ?>
        <?= Yii::$app->session->setFlash(
            'success',
            Yii::t('app', 'Gracias por contactar con nosotros, {username}. Nosotros responderemos a la mayor brevedad posible.', [
                'username' => $model->user->username === '' ?: Yii::t('app', 'invitado'),
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
        <?= $this->render('_form', [
            'model' => $model,
        ]); ?>
    <?php endif; ?>
</div>