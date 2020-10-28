<?php

/* @var $this yii\web\View */

use app\helpers\Bootstrap;
use app\models\User;
use yii\bootstrap4\Html;
use yii\helpers\Url;

\yii\web\YiiAsset::register($this);
?>

<div class="sidebar">
    <div id="toast"></div>
    <?php if (!Yii::$app->user->isGuest) : ?>
        <div class="row mb-4">
            <div class="w-100">
                <div class="card-header">
                    <div class="lead"><?= Yii::t('app', 'Carrito') ?></div>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= Yii::t('app', 'Artículos en el carrito') ?></h5>
                    <div class="row justify-content-between">
                        <div class="col-10 py-2">
                            Amontillado
                        </div>
                        <div class="col-2">
                            <div class="badge badge-secondary badge-pill p-2">
                                1
                            </div>
                        </div>
                    </div>
                    <div class="mt-xl-1 horizontal-divider"></div>
                </div>
            </div>
        </div>
    <?php endif ?>
    <div class="row mb-4">
        <div class="w-100">
            <div class="card-header">
                <div class="lead"><?= Yii::t('app', 'Compartir') ?></div>
            </div>
            <div class="card-body">
                <div class="icon-container1 d-flex mt-2">
                    <?= Html::a('<i class=" img-thumbnail fab fa-twitter fa-2x" style="color:#0098F4;background-color: aliceblue"></i>
                        <p class="mt-2">Twitter</p>', 'https://twitter.com/home?status=http://venenciame.herokuapp.com', [
                        'class' => 'smd'
                    ]) ?>

                    <?= Html::a('<i class=" img-thumbnail fab fa-facebook fa-2x" style="color:#4E4990;background-color: aliceblue"></i>
                        <p class="mt-2">Facebook</p>', 'https://www.facebook.com/sharer/sharer.php?u=http://venenciame.herokuapp.com', [
                        'class' => 'smd'
                    ]) ?>
                    <?= Html::a('<i class=" img-thumbnail fab fa-linkedin fa-2x" style="color:#0067B1;background-color: aliceblue"></i>
                        <p class="mt-2">Linkedin</p>', 'https://www.linkedin.com/shareArticle?mini=true&url=http://venenciame.herokuapp.com&title=&summary=&source=', [
                        'class' => 'smd'
                    ]) ?>
                    <?= Html::a('<i class=" img-thumbnail fab fa-pinterest fa-2x" style="color:#DC0000;background-color: aliceblue"></i>
                        <p class="mt-2">Pinterest</p>', 'https://pinterest.com/pin/create/button/?url=http://venenciame.herokuapp.com&media=&description=', [
                        'class' => 'smd'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="w-100">
        <div class="card-header">
            <div class="lead"><?= Yii::t('app', 'Enlaces') ?></div>
        </div>
        <ul class="list-group list-group-flush">
            <?php if (Yii::$app->user->isGuest) : ?>
                <li class="list-group-item">
                    <?= Html::a(Yii::t('app', 'Conectarse'), Url::to(['site/login']), [
                        'class' => 'show-modal-login',
                        'value' => Url::to(['site/login']),
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-login-sidebar',
                        'title' => Yii::t('app', 'Ir a la página de conexión de usuarios.'),
                    ]) ?>
                </li>
                <li class="list-group-item">
                    <?= Html::a(Yii::t('app', 'Crear cuenta'), Url::to(['site/register']), [
                        'class' => 'show-modal-register',
                        'value' => Url::to(['site/register']),
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-register-sidebar',
                        'title' => Yii::t('app', 'Ir a la página de registro de usuarios.'),
                    ]) ?>
                </li>
            <?php else : ?>
                <?php if (Yii::$app->controller->action->id === 'update') : ?>
                    <li class="list-group-item">
                        <?= Html::a(Yii::t('app', 'Desconectarse'), Url::to(['site/logout']), [
                            'class' => 'show-modal-logout',
                            'value' => Url::to(['site/logout']),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-logout-sidebar',
                            'title' => Yii::t('app', 'Desconectarse del sitio')
                        ]) ?>
                    </li>
                    <li class="list-group-item">
                        <?= Html::a(Yii::t('app', 'Perfil'), Url::to(['user/view', 'id' => Yii::$app->user->id]), [
                            'class' => 'font-transition-small',
                            'title' => Yii::t('app', 'Ir a tu perfil.'),
                        ]) ?>
                    </li>
                    <?php if (User::isPartner()) : ?>
                        <li class="list-group-item">
                            <?= Html::a(Yii::t('app', 'Administrar cuenta de socio'), Url::to(['partners/view', 'id' => Yii::$app->user->identity->partners->id]), [
                                'class' => 'font-transition-small',
                                'title' => Yii::t('app', 'Ir al perfil de socio de tu cuenta.'),
                            ]) ?>
                        </li>
                    <?php endif ?>
                <?php else : ?>
                    <li class="list-group-item">
                        <?= Html::a(Yii::t('app', 'Perfil'), Url::to(['user/view', 'id' => Yii::$app->user->id]), [
                            'class' => 'font-transition-small',
                            'title' => Yii::t('app', 'Ir al perfil de tu cuenta.'),
                        ]) ?>
                    </li>
                    <li class="list-group-item">
                        <?= Html::a(Yii::t('app', 'Configuración de la cuenta'), Url::to(['user/update', 'id' => Yii::$app->user->id]), [
                            'class' => 'font-transition-small',
                            'title' => Yii::t('app', 'Ir a la configuración de tu cuenta.'),
                        ]) ?>
                    </li>
                    <?php if (User::isPartner()) : ?>
                        <li class="list-group-item">
                            <?= Html::a(Yii::t('app', 'Administrar cuenta de socio'), Url::to(['partners/view', 'id' => Yii::$app->user->identity->partners->id]), [
                                'class' => 'font-transition-small',
                                'title' => Yii::t('app', 'Ir al perfil de socio de tu cuenta.'),
                            ]) ?>
                        </li>
                    <?php endif ?>
                    <li class="list-group-item">
                        <?= Html::a(Yii::t('app', 'Desconectarse'), Url::to(['site/logout']), [
                            'class' => 'show-modal-logout',
                            'value' => Url::to(['site/logout']),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-logout-sidebar',
                            'title' => Yii::t('app', 'Desconectarse del sitio')
                        ]) ?>
                    </li>
                <?php endif ?>
            <?php endif ?>
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
<?php if (!Yii::$app->user->isGuest) : ?>
    <?php if (User::isPartner()) : ?>
        <div class="row my-4">
            <div class="w-100">
                <div class="card-header">
                    <div class="lead"><?= Yii::t('app', 'Mis ventas') ?></div>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= Yii::t('app', 'Panel de administración de ventas de socios.') ?></h5>
                    <p class="card-text"><?= Yii::t('app', 'Aquí podrás administrar tus ventas.') ?></p>
                    <?= Html::a(Yii::t('app', 'Administrar'), Url::to(['partners/view', 'id' => User::partnerId()]), [
                        'class' => 'font-transition-small',
                        'title' => Yii::t('app', 'Solicitar al administrador una cuenta de distribuidor'),
                    ]) ?>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="row my-4">
            <div class="w-100">
                <div class="card-header">
                    <div class="lead"><?= Yii::t('app', 'Participa') ?></div>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= Yii::t('app', 'Solicitd para ventas en la web.') ?></h5>
                    <p class="card-text"><?= Yii::t('app', 'Si ya eres usuario de nuestra web, y quieres vender tus productos, solicítalo aquí.') ?></p>
                    <?= Html::a(Yii::t('app', 'Solicitar'), Url::to(['partners/request']), [
                        'class' => 'font-transition-small',
                        'title' => Yii::t('app', 'Solicitar al administrador una cuenta de distribuidor'),
                    ]) ?>
                </div>
            </div>
        </div>
    <?php endif ?>
<?php endif ?>
</div>