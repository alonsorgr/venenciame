<?php

use yii\helpers\Url;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

?>

<div class="user-small">
    <div itemscope itemtype="http://schema.org/Person" class="row justify-content-between">
        <div class="col-xl-2 d-flex justify-content-center justify-content-xl-start">
            <?= Html::img(Html::encode(Url::base(true) . '/' . $model->link), [
                'alt' => Yii::t('app', 'Imagen de usuario'),
                'data-action' => 'zoom',
                'title' => Yii::t('app', 'Imagen de usuario'),
                'class' => 'user-avatar',
            ]); ?>
        </div>
        <div class="col-xl-8">
            <div class="row justify-content-center justify-content-xl-start">
                <?= Html::a(Html::encode($model->fullname), ['user/view', 'id' => $model->id], [
                    'class' => 'lead',
                    'itemprop' => 'name',
                    'data-pjax' => 0,
                ]); ?>
            </div>
            <div class="row justify-content-center justify-content-xl-start mt-2">
                <?= Html::a(Html::encode($model->username), ['user/view', 'id' => $model->id], [
                    'itemprop' => 'alternateName',
                    'data-pjax' => 0,
                ]); ?>
            </div>
            <div class="row justify-content-center justify-content-xl-start align-items-baseline mt-2">
                <div itemprop="email">
                    <i class="fas fa-envelope mr-1"></i>
                    <?= Yii::$app->formatter->asEmail(Html::encode($model->email)); ?>
                </div>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="row justify-content-center justify-content-xl-start align-items-baseline mt-sm-2 d-xl-inline-block">
                <i class="fas fa-calendar mr-2"></i>
                <?= Yii::t('app', 'Registrado el {date}', [
                    'date' => Html::encode(Yii::$app->formatter->asDate($model->created_at)),
                ]); ?>
            </div>
        </div>
    </div>
    <div class="mt-xl-1 horizontal-divider"></div>
</div>