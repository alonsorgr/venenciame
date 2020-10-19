<?php

/* @var $this yii\web\View */
/* @var $model app\models\Partners */

use app\helpers\Bootstrap;
use yii\bootstrap4\Html;

\yii\web\YiiAsset::register($this);

?>

<div class="partners-administration-main">
    <div class="row">
        <div class="col-xl-6">
            <?= Html::a('<i class="fas fa-edit mr-md-2"></i>' . Yii::t('app', 'Editar información'), ['/partners/update', 'id' => $model->id], [
                'class' => 'btn btn-outline-primary btn-block mt-5',
                'title' => Yii::t('app', 'Editar información'),
            ]); ?>
        </div>
        <div class="col-xl-6">
            <?= Html::a('<i class="fas fa-plus mr-md-2"></i>' . Yii::t('app', 'Agregar nuevo producto'), ['/articles/create'], [
                'class' => 'btn btn-outline-primary btn-block mt-5',
                'title' => Yii::t('app', 'Agregar nuevo producto'),
            ]); ?>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col">
            <?= Bootstrap::header(Yii::t('app', 'Artículos pendientes de publicación')); ?>
        </div>
    </div>
</div>