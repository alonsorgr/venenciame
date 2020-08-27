<?php

/* @var $this yii\web\View */

use app\helpers\Bootstrap;
use app\models\User;
use yii\bootstrap4\Html;
use yii\helpers\Url;

\yii\web\YiiAsset::register($this);
?>

<div class="partners-sidebar my-4">
    <div class="row">
        <div class="card w-100">
            <div class="card-header">
                <div class="lead"><?= Yii::t('app', 'Enlaces') ?></div>
            </div>
            <ul class="list-group list-group-flush">
                <?php if (Yii::$app->user->isGuest) : ?>
                    <li class="list-group-item">
                        <?= Html::a(Yii::t('app', 'Conectarse'), Url::to(['site/sign-in']), [
                            'class' => 'font-transition-small',
                            'title' => Yii::t('app', 'Ir a la página de registro de conexión de usuarios.'),
                        ]) ?>
                    </li>
                    <li class="list-group-item">
                        <?= Html::a(Yii::t('app', 'Crear cuenta'), Url::to(['site/sign-up']), [
                            'class' => 'font-transition-small',
                            'title' => Yii::t('app', 'Ir a la página de registro de usuarios.'),
                        ]) ?>
                    </li>
                <?php else : ?>
                    <?php if (Yii::$app->controller->action->id === 'update') : ?>
                        <li class="list-group-item">
                            <?= Html::a(Yii::t('app', 'Perfil'), Url::to(['user/view', 'id' => Yii::$app->user->id]), [
                                'class' => 'font-transition-small',
                                'title' => Yii::t('app', 'Ir a tu perfil.'),
                            ]) ?>
                        </li>
                    <?php else : ?>
                        <li class="list-group-item">
                            <?= Html::a(Yii::t('app', 'Configuración de la cuenta'), Url::to(['user/update', 'id' => Yii::$app->user->id]), [
                                'class' => 'font-transition-small',
                                'title' => Yii::t('app', 'Ir a la configuración de tu cuenta.'),
                            ]) ?>
                        </li>
                    <?php endif ?>
                <?php endif ?>
                <li class="list-group-item">
                    <?= Html::a(Yii::t('app', 'Desconectarse'), Url::to(['site/logout']), [
                        'class' => 'show-modal-logout',
                        'value' => Url::to(['site/logout']),
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-logout',
                        'title' => Yii::t('app', 'Desconectarse del sitio')
                    ]) ?>
                </li>
                <?php if (Yii::$app->controller->action->id === 'contact') : ?>
                    <li class="list-group-item">
                        <?= Html::a(Yii::t('app', 'Acerca de {title}', ['title' => Yii::$app->name]), Url::to(['site/about']), [
                            'class' => 'font-transition-small',
                            'title' => Yii::t('app', 'Ir a la página de acerca de {title}', ['title' => Yii::$app->name]),
                        ]) ?>
                    </li>
                <?php else : ?>
                    <li class="list-group-item">
                        <?= Html::a(Yii::t('app', 'Contacto'), Url::to(['site/contact']), [
                            'class' => 'font-transition-small',
                            'title' => Yii::t('app', 'Ir a la página de contacto.'),
                        ]) ?>
                    </li>
                <?php endif ?>
                <li class="list-group-item">
                    <?= Html::a(Yii::t('app', 'Ayuda'), 'https://alonsorgr.github.io/venenciame/', [
                        'class' => 'font-transition-small',
                        'title' => Yii::t('app', 'Ir a la página de ayuda.'),
                    ]) ?>
                </li>
            </ul>
        </div>
    </div>
    <?php if (!Yii::$app->user->isGuest && User::isPartner()) : ?>
        <div class="row mt-4">
            <div class="card w-100">
                <div class="card-header">
                    <div class="lead"><?= Yii::t('app', 'Mis ventas') ?></div>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= Yii::t('app', 'Panel de administración de ventas de socios.') ?></h5>
                    <p class="card-text"><?= Yii::t('app', 'Aquí podrás administrar tus ventas.') ?></p>
                    <?= Html::a(Yii::t('app', 'Administrar'), Url::to(['partners/index']), [
                        'class' => 'font-transition-small',
                        'title' => Yii::t('app', 'Solicitar al administrador una cuenta de distribuidor'),
                    ]) ?>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="row mt-4">
            <div class="card w-100">
                <div class="card-header">
                    <div class="lead"><?= Yii::t('app', 'Ayuda') ?></div>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= Yii::t('app', 'Instrucciones.') ?></h5>
                    <p class="card-text"><?= Yii::t('app', 'Completa el formulario.') ?></p>
                    <p class="card-text"><?= Yii::t('app', 'Se le enviará un correo electrónico indicando que la solicitud está en revisión.') ?></p>
                    <p class="card-text"><?= Yii::t('app', 'Una vez confirmada por el administrador, le llegará una notificación por correo electrónico y en la web.') ?></p>
                    <p class="card-text"><?= Yii::t('app', 'Una vez confirmada la solicitud, podrás acceder al panel para completar la información de su empresa y crear nuevas ventas que serán moderanad por el administrador.') ?></p>
                    
                </div>
            </div>
        </div>
    <?php endif ?>
</div>
<?php Bootstrap::modal([
    'id' => 'modal-logout',
    'image' => 'fas fa-sign-out-alt',
    'size' => 'modal-lg',
    'title' => Yii::t('app', 'Desconectarse'),
]) ?>