<?php

use app\models\User;
use kartik\rating\StarRating;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Reviews */
/* @var $form yii\bootstrap4\ActiveForm */

?>

<div class="reviews-form">
    <div class="row">
        <div class="col-12">
            <?php $form = ActiveForm::begin([
                'id' => 'reviews-form',
                'enableAjaxValidation' => true,
            ]); ?>
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
                            <?= Html::a(Html::encode(Yii::$app->user->identity->username) . ' ', Url::to(['user/view', 'id' => User::id()])); ?>
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
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'user_id')->hiddenInput([
                        'value' => User::id(),
                    ])->label(false); ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'article_id')->hiddenInput([
                        'value' => 1,
                    ])->label(false); ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?= $form->field($model, 'review')->textarea([
                        'rows' => 6,
                        'maxlength' => true,
                        'placeholder' => Yii::t('app', 'Escriba su opinión'),
                        'title' => Yii::t('app', 'Escriba su opinión'),
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-3">
                    <div class="form-group mt-2">
                        <?= Html::submitButton('<i class="fas fa-comments mr-2"></i>' . Yii::t('app', 'Comentar'), ['class' => 'btn btn-primary btn-block']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>