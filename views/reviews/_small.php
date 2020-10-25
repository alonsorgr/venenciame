<?php

use app\models\User;
use kartik\rating\StarRating;
use yii\helpers\Url;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Reviews */

?>
<div class="reviews-small">
    <div class="row">
        <div class="col-12">
            <div class="row justify-content-between">
                <div class="col-12 col-xl-6">
                    <div class="row">
                        <div class="col-12 col-xl-1">
                            <div class="mx-auto">
                                <div class="col d-flex justify-content-center align-items-center">
                                    <div class="user-box-small">
                                        <div class="image-profile">
                                            <?= Html::img(Html::encode(Url::base(true) . '/' . Yii::$app->user->identity->link), [
                                                'alt' => Yii::t('app', 'Avatar de usuario'),
                                                'title' => Yii::t('app', 'Avatar de usuario'),
                                                'width' => 32,
                                                'data-action' => 'zoom',
                                            ]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-11 text-center text-xl-left mt-2">
                            <?= Html::a(Html::encode(Yii::$app->user->identity->username) . ' ', Url::to(['user/view', 'id' => User::id()])) . Yii::t('app', 'comentó el ') . Yii::$app->formatter->asDate($model->created_at) . ' ' . Yii::t('app', 'sobre ') .  Html::encode($model->article->title) . '.'?> 
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-6 d-flex justify-content-center justify-content-xl-end text-center text-xl-right">
                    <?= StarRating::widget([
                        'name' => 'score',
                        'value' => $model->score,
                        'pluginOptions' => [
                            'min' => 0,
                            'max' => 5,
                            'step' => 1,
                            'size' => 'sm',
                            'theme' => 'krajee-svg',
                            'showClear' => false,
                            'showCaption' => false,
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12 text-center text-xl-left">
            <?= Html::encode($model->review); ?>
        </div>
    </div>
    <div class="mt-xl-1 horizontal-divider"></div>
</div>