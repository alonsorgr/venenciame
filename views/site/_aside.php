<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;
use yii\helpers\Url;

\yii\web\YiiAsset::register($this);
?>

<div class="help-aside my-4">
    <div class="row">
        <div class="card w-100">
            <div class="card-header">
                <div class="lead"><?= Yii::t('app', 'Enlaces') ?></div>
            </div>
            <ul class="list-group list-group-flush">
                <?php if (Yii::$app->user->isGuest) : ?>
                    <li class="list-group-item">
                        <?= Html::a(Yii::t('app', 'Conectarse'), Url::to(['site/sign-in']), [
                            'id' => 'signin',
                            'class' => 'font-transition-small',
                            'title' => Yii::t('app', 'Ir a la página de registro de conexión de usuarios.'),
                        ]) ?>
                    </li>
                    <li class="list-group-item">
                        <?= Html::a(Yii::t('app', 'Crear cuenta'), Url::to(['site/sign-up']), [
                            'id' => 'signup',
                            'class' => 'font-transition-small',
                            'title' => Yii::t('app', 'Ir a la página de registro de usuarios.'),
                        ]) ?>
                    </li>
                <?php else : ?>
                    <li class="list-group-item">
                        <?= Html::a(Yii::t('app', 'Perfil'), Url::to(['user/view', 'id' => Yii::$app->user->id]), [
                            'id' => 'signin',
                            'class' => 'font-transition-small',
                            'title' => Yii::t('app', 'Ir a tu perfil.'),
                        ]) ?>
                    </li>
                    <li class="list-group-item">
                        <?= Html::a(Yii::t('app', 'Configuración de la cuenta'), Url::to(['user/update', 'id' => Yii::$app->user->id]), [
                            'id' => 'signup',
                            'class' => 'font-transition-small',
                            'title' => Yii::t('app', 'Ir a la configuración de tu cuenta.'),
                        ]) ?>
                    </li>
                <?php endif ?>
                <li class="list-group-item">
                    <?= Html::a(Yii::t('app', 'Cuenta para distribuidores'), Url::to(['site/sign-up-dealer']), [
                        'id' => 'signup-distributor',
                        'class' => 'font-transition-small',
                        'title' => Yii::t('app', 'Ir a la página de registro de distribuidores.'),
                    ]) ?>
                </li>
                <?php if (Yii::$app->controller->action->id === 'contact') : ?>
                    <li class="list-group-item">
                        <?= Html::a(Yii::t('app', 'Acerca de {title}', ['title' => Yii::$app->name]), Url::to(['site/about']), [
                            'id' => 'contact',
                            'class' => 'font-transition-small',
                            'title' => Yii::t('app', 'Ir a la página de acerca de {title}', ['title' => Yii::$app->name]),
                        ]) ?>
                    </li>
                <?php else : ?>
                    <li class="list-group-item">
                        <?= Html::a(Yii::t('app', 'Contacto'), Url::to(['site/contact']), [
                            'id' => 'contact',
                            'class' => 'font-transition-small',
                            'title' => Yii::t('app', 'Ir a la página de contacto.'),
                        ]) ?>
                    </li>
                <?php endif ?>
                <li class="list-group-item">
                    <?= Html::a(Yii::t('app', 'Ayuda'), 'https://alonsorgr.github.io/venenciame/', [
                        'id' => 'help',
                        'class' => 'font-transition-small',
                        'title' => Yii::t('app', 'Ir a la página de ayuda.'),
                    ]) ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="row mt-4">
        <div class="card w-100">
            <div class="card-header">
                <div class="lead"><?= Yii::t('app', 'Participa') ?></div>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= Yii::t('app', 'Solicitd para ventas en la web.') ?></h5>
                <p class="card-text"><?= Yii::t('app', 'Si ya eres usuario de nuestra web, y quieres vender tus productos, solicítalo aquí.') ?></p>
                <?= Html::a(Yii::t('app', 'Solicitar'), Url::to(['request/create']), [
                    'id' => 'request',
                    'class' => 'font-transition-small',
                    'title' => Yii::t('app', 'Solicitar al administrador una cuenta de distribuidor'),
                ]) ?>
            </div>
        </div>
    </div>
</div>