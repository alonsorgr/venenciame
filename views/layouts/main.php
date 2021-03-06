<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\MapAsset;
use app\helpers\Bootstrap;
use app\helpers\Cookies;
use app\helpers\Navigation;
use yii\helpers\Url;

AppAsset::register($this);
MapAsset::register($this);

if (!Yii::$app->user->isGuest) {
    $url = Url::to(['cart-items/count']);
    $js = <<<EOT
        $.ajax({
            type : 'POST',
            url : '$url',
            success: function(response) {
                response = JSON.parse(response);
                $('#shopping-cart-counter').text(response.count);
            }
        });
    EOT;
    $this->registerJs($js);
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Html::img('@web/img/site/logo.svg', [
                'alt' => Yii::$app->name,
                'class' => 'img-fluid logo-size',
                'style' => 'margin-top: -20px',
            ]),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-light bg-light navbar-expand-xl fixed-top shadow-lg',
            ],
            'collapseOptions' => [
                'class' => 'justify-content-end',
            ],
            'innerContainerOptions' => [
                'class' => 'container-fluid',
            ]
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav text-uppercase'],
            'items' => Navigation::items(),
        ]);
        NavBar::end();
        ?>

        <div class="container-fluid mb-5">
            <div class="row justify-content-between">
                <?php $class = Yii::$app->controller->id === 'admin' ? 'col-xl-12' : 'col-xl-9' ?>
                <div class="col-sm-12 <?= $class ?>">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
                <?php $class = Yii::$app->controller->id === 'admin' ? 'd-none' : '' ?>
                <div class="<?= $class ?> col-sm-12 col-xl-3 my-sm-5 my-xl-0 pl-sm-4 pr-sm-4 pl-xl-5">
                    <?= $this->render('_sidebar'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php Bootstrap::modal([
        'id' => 'modal-login',
        'image' => 'fas fa-sign-in-alt',
        'title' => Yii::t('app', 'Conectarse'),
    ]) ?>
    <?php Bootstrap::modal([
        'id' => 'modal-logout',
        'image' => 'fas fa-sign-out-alt',
        'size' => 'modal-lg',
        'title' => Yii::t('app', 'Desconectarse'),
    ]) ?>
    <?php Bootstrap::modal([
        'id' => 'modal-register',
        'image' => 'fas fa-sign-in-alt',
        'title' => Yii::t('app', 'Registrarse'),
    ]) ?>
    <footer class="mb-5">
        <div class="container">
            <div class="row text-center d-flex justify-content-center mb-3">
                <div class="col-md-3 mb-3">
                    <?= Html::a(Yii::t('app', 'Acerca de nosotros'), Url::to(['site/about']), [
                        'id' => 'about-us',
                        'class' => 'h6 text-uppercase font-weight-bold font-transition-small',
                        'title' => Yii::t('app', 'Lea más acerca de nuestra empresa'),
                    ]) ?>
                </div>
                <div class="col-md-3 mb-3">
                    <?= Html::a(Yii::t('app', 'Nuestros vinos'), '#!', [
                        'id' => 'our-wines',
                        'class' => 'h6 text-uppercase font-weight-bold font-transition-small',
                        'title' => Yii::t('app', 'Navegue entre nuestra gran colección de vinos'),
                    ]) ?>
                </div>
                <div class="col-md-3 mb-3">
                    <?= Html::a(Yii::t('app', 'Ayuda'), '#!', [
                        'id' => 'help',
                        'class' => 'h6 text-uppercase font-weight-bold font-transition-small',
                        'title' => Yii::t('app', 'Ir a la ayuda del sitio web'),
                    ]) ?>
                </div>
                <div class="col-md-3 mb-3">
                    <?= Html::a(Yii::t('app', 'Contacto'), Url::to(['site/contact']), [
                        'id' => 'contact',
                        'class' => 'h6 text-uppercase font-weight-bold font-transition-small',
                        'title' => Yii::t('app', 'Ir a la página de contacto'),
                    ]) ?>
                </div>
            </div>
            <div class="row d-flex text-center justify-content-center mb-md-0 mb-4">
                <div class="col-md-9 col-12 mt-2">
                    <p class="lead"><?= Yii::t('app', 'El proyecto "Venénciame" está enfocado a una tienda online para la venta de vinos españoles de denominación de origen, ofreciéndo un servicio a pequeñas bodegas que desean abrirse en el mercado.') ?></p>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col-md-12">
                    <div class="row d-flex text-center justify-content-center mb-md-0">
                        <div class="col-md-8 col-12 mt-5">
                            <div class="fab fa-facebook-f fa-lg mr-4"> </div>
                            <div class="fab fa-twitter fa-lg mr-4"> </div>
                            <div class="fab fa-linkedin-in fa-lg"> </div>
                            <div class="fab fa-instagram fa-lg ml-4"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <span><?= Yii::t('app', 'Desarrollado por Alonso García') ?></span>
            <?= Html::a('Visita su perfil en GitHub', 'https://github.com/alonsorgr', [
                'id' => 'github-link',
                'class' => 'powered d-block',
                'title' => Yii::t('app', 'Perfil del desarrollador en GitHub'),
            ]) ?>
        </div>
    </footer>
    <?= Cookies::register(); ?>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>