<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;
use app\helpers\Bootstrap;

?>
<div class="site-logout CookieMonsterBox cookie">
    <div class="row justify-content-between m-4">
        <div class="col col-12 col-lg-9">
            <div class="lead-lg mb-2">
                <?= Yii::t('app', 'Esta página web usa cookies') ?>
            </div>
            <div class="lead-sm">
                <?= Yii::t('app', 'Las cookies de este sitio web se usan para personalizar el contenido y los anuncios, ofrecer funciones de redes sociales y analizar el tráfico. Además, compartimos información sobre el uso que haga del sitio web con nuestros partners de redes sociales, publicidad y análisis web, quienes pueden combinarla con otra información que les haya proporcionado o que hayan recopilado a partir del uso que haya hecho de sus servicios.') ?>
            </div>
        </div>
        <div class="col col-12 col-lg-3 d-flex justify-content-end p-5">
            <?= Html::button(Yii::t('app', 'Aceptar cookies'), [
                'class' => 'CookieMonsterOk btn btn-primary font-weight-bold'
            ]) ?>
        </div>
    </div>
</div>