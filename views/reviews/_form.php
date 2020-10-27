<?php

use app\helpers\Bootstrap;
use app\helpers\Routes;
use app\models\User;
use kartik\rating\StarRating;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Reviews */
/* @var $form yii\bootstrap4\ActiveForm */

$url = Url::to(['reviews/create']);

$js = <<<EOT
    $('#reviews-form').on('beforeSubmit', function(e) {
        var form = $(this);
        var formData = form.serialize();
        $.ajax({
            url: '$url',
            type: 'POST',
            data: formData,
            success: function (data) {
                $('#modal-reviews-article').modal('toggle');
                $('#reviews-btn').remove();
                $('#modal-reviews-article').modal('toggle');
                if($("#reviews-pjax").length != 0) {
                    $.pjax.reload({ container: '#reviews-pjax', timeout: false });
                }
            },
        });

    }).on('submit', function(e){
        e.preventDefault();
    });
EOT;

$this->registerJs($js);

?>
<div class="reviews-form m-3">
    <div class="row">
        <div class="col-12">
            <?php $form = ActiveForm::begin([
                'id' => 'reviews-form',
            ]); ?>
            <div class="row justify-content-between">
                <div class="col-12 col-xl-6">
                    <div class="row">
                        <div class="col-12 col-xl-1 mr-2">
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
                        <div class="col-12 col-xl-10 text-center text-xl-left mt-2">
                            <?= Html::a(Html::encode(Yii::$app->user->identity->username) . ' ', Url::to(['user/view', 'id' => User::id()])); ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-6 d-flex justify-content-center justify-content-xl-end text-center text-xl-right">
                    <?= $form->field($model, 'score')->widget(StarRating::class, [
                        'name' => 'rating-form',
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
                        'value' => Routes::getId(Yii::$app->request->referrer),
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