<?php

use yii\helpers\Url;
use yii\bootstrap4\Html;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Partners */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Socios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="partners-view">
    <div class="row justify-content-between">
        <div class="col-xl-8">
            <div class="row mt-5">
                <div class="col-12">
                    <?= $this->render('_small', [
                        'model' => $model,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <?= $this->render('_sidebar'); ?>
        </div>
    </div>
</div>