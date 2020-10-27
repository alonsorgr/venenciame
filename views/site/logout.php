<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\bootstrap4\Html;
use app\helpers\Bootstrap;

$this->title = Yii::t('app', 'Desconectarse');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-logout">
    <div class="row">
        <div class="col mt-3 mx-3">
            <div class="lead">
                <?= Yii::t('app', '¿Desea desconectarse del {appname}?', [
                    'appname' => Yii::$app->name,
                ]) ?>
            </div>
        </div>
    </div>
    <div class="row justify-content-end my-3 mx-3">
        <?= Html::a(Yii::t('app', 'Desconectarse'), Url::to(['site/logout']), [
            'data-method' => 'POST',
            'class' => 'btn btn-danger',
            'title' => Yii::t('app', 'Desconectarse del sitio')
        ]) ?>
    </div>
</div>