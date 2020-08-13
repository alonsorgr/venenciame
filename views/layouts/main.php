<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;
use app\helpers\Cookies;
use yii\helpers\Url;
use yii\web\View;

AppAsset::register($this);
Cookies::init($this);

$this->registerJsFile("@web/js/effects.js", [
    'depends' => [
        \yii\web\JqueryAsset::class,
    ]
]);

$this->registerJs("loading()", View::POS_READY);

$this->title = Yii::$app->name;

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
                'width' => '200',
                'heigth' => '100',
                'alt' => Yii::$app->name,
                'style' => 'margin-top: -20px',
            ]),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-light bg-light navbar-expand-lg fixed-top shadow-lg',
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
            'items' => [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'About', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
                Yii::$app->user->isGuest ? (['label' => 'Login', 'url' => ['/site/login']]) : ('<li class="nav-item">'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-dark nav-link logout']
                    )
                    . Html::endForm()
                    . '</li>')
            ],
        ]);
        NavBar::end();
        ?>

        <div class="container-fluid">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

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
                            <i class="fab fa-facebook-f fa-lg mr-4"> </i>
                            <i class="fab fa-twitter fa-lg mr-4"> </i>
                            <i class="fab fa-linkedin-in fa-lg"> </i>
                            <i class="fab fa-instagram fa-lg ml-4"> </i>
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
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-primary">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>