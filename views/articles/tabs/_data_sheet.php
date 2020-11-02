<?php

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

use app\helpers\Bootstrap;
use yii\bootstrap4\Html;

\yii\web\YiiAsset::register($this);

?>

<div class="article-data-sheet">
    <div class="row">
        <div class="col mt-5 text-center text-xl-left">
            <div class="font-weight-bold">
                <?= Yii::t('app', 'Descripción'); ?>
            </div>
            <?= Html::encode($model->description) ?>
        </div>
    </div>
    <div class="row">
        <div class="col mt-5 text-center text-xl-left">
            <div class="font-weight-bold">
                <?= Yii::t('app', 'Graduación alcohólica'); ?>
            </div>
            <?= Yii::$app->formatter->asPercent(Html::encode($model->degrees)) . ' vol'; ?>
        </div>
    </div>
    <div class="row">
        <div class="col mt-5 text-center text-xl-left">
            <div class="font-weight-bold">
                <?= Yii::t('app', 'Variedad de la uva'); ?>
            </div>
            <?= Html::encode($model->variety) ?>
        </div>
    </div>
    <div class="row">
        <div class="col mt-5 text-center text-xl-left">
            <div class="font-weight-bold">
                <?= Yii::t('app', 'Maridaje'); ?>
            </div>
            <?= Html::encode($model->pairing) ?>
        </div>
    </div>
    <div class="row">
        <div class="col mt-5 text-center text-xl-left">
            <div class="font-weight-bold">
                <?= Yii::t('app', 'Opinión del vendedor'); ?>
            </div>
            <?= Html::encode($model->review) ?>
        </div>
    </div>
</div>