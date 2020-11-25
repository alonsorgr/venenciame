<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\OrderItems */

\yii\web\YiiAsset::register($this);
?>
<div class="order-items-view">
    <div class="row mb-4">
        <div class="col-xl-1">
            <div class="col d-flex justify-content-center mt-4">
                <?= Html::img(Html::encode(Url::base(true) . '/' . $model->article->link), [
                'alt' => Yii::t('app', 'Imagen del artículo'),
                'title' => Yii::t('app', 'Imagen del artículo'),
                'width' => 24,
                'data-action' => 'zoom',
            ]); ?>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="text-center text-md-left font-weight-bold mt-3">
                <?= Yii::t('app', 'Arículo'); ?>
            </div>
            <div class="text-center text-md-left mt-2">
                <?= Html::encode($model->article->title); ?>
            </div>
        </div>
        <div class="col-xl-7">
            <div class="text-center text-md-left font-weight-bold mt-3">
                <?= Yii::t('app', 'Cantidad'); ?>
            </div>
            <div class="text-center text-md-left mt-2">
                <?= Html::encode($model->quantity); ?>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="text-center text-md-right">
                <div class="text-center text-md-right font-weight-bold mt-3">
                    <?= Yii::t('app', 'Precio'); ?>
                </div>
                <div class="text-center text-md-right mt-2">
                    <?= Html::encode(Yii::$app->formatter->asCurrency($model->price)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="my-xl-3 horizontal-divider"></div>
</div>