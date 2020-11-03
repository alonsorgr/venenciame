<?php

use yii\helpers\Url;
use yii\bootstrap4\Html;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Partners */

if (!Yii::$app->user->isGuest) {

    $notifyFollow = Yii::t('app', 'Has agregado a favoritos a {partner}', [
        'partner' => $model->name,
    ]);

    $notifyUnfollow = Yii::t('app', 'Has eliminado de favoritos a {partner}', [
        'partner' => $model->name,
    ]);

    $follow = Url::to(['followers/follow', 'user_id' => User::id(), 'partner_id' => $model->id]);
    $id = $model->id;

    $js = <<<EOT
    $(document).ready(function(){
        $('#partner-follow-' + $id).css('cursor', 'pointer');
        $.ajax({
            type : 'GET',
            url : '$follow',
            success: function(response) {
                response = JSON.parse(response);
                $('#partner-follow-' + $id).removeClass('far');
                $('#partner-follow-' + $id).addClass(response.class);
                $('#partner-follow-' + $id).prop('title', response.title);
            }
        });
        $('#partner-follow-' + $id).click(function(e){
            e.preventDefault();
            $.ajax({
                type : 'POST',
                url : '$follow',
                success: function(response) {
                    response = JSON.parse(response);
                    $('#partner-follow-' + $id).removeClass('fas');
                    $('#partner-follow-' + $id).addClass(response.class);
                    $('#partner-follow-' + $id).prop('title', response.title);
                    if($("#partners-followed-pjax").length != 0) {
                        $.pjax.reload({ container: '#partners-followed-pjax', timeout: false });
                    }
                    if($("#partners-index-pjax").length != 0) {
                        $.pjax.reload({ container: '#partners-index-pjax', timeout: false });
                    }
                    if (response.class == 'fas') {
                        $('#partner-follow-' + $id).notify('$notifyFollow', {
                            style: 'bootstrap',
                            className: 'success',
                            position: 'right'
                        });
                    } else {
                        $('#partner-follow-' + $id).notify('$notifyUnfollow', {
                            style: 'bootstrap',
                            className: 'error',
                            position: 'right'
                        });
                    }
                }
            });
        });
    });
    EOT;

    $this->registerJs($js);
}
?>

<div class="partner-small">
    <div itemscope itemtype="http://schema.org/Organization" class="row justify-content-between">
        <div class="col-xl-2 d-flex justify-content-center justify-content-xl-start">
            <?= Html::img(Html::encode(Url::base(true) . '/' . $model->link), [
                'alt' => Yii::t('app', 'Logo corporativo'),
                'data-action' => 'zoom',
                'title' => Yii::t('app', 'Logo corporativo'),
                'class' => 'avatar',
            ]); ?>
        </div>
        <div class="col-xl-6">
            <div class="row justify-content-center justify-content-xl-start">
                <?= Html::a(Html::encode($model->name), ['partners/view', 'id' => $model->id], [
                    'class' => 'lead',
                    'itemprop' => 'legalName',
                    'data-pjax' => 0,
                ]); ?>
            </div>
            <div class="row justify-content-center justify-content-xl-start text-center text-xl-left mt-2">
                <?= Html::encode($model->description); ?>
            </div>
            <div class="row justify-content-center justify-content-xl-start align-items-baseline mt-2">
                <div itemprop="email">
                    <i class="fas fa-envelope mr-1"></i>
                    <?= Yii::$app->formatter->asEmail(Html::encode($model->email)); ?>
                </div>
            </div>
        </div>
        <div class="col-xl-4 pr-xl-5">
            <div class="row justify-content-center justify-content-xl-end my-2">
                <?php if (!Yii::$app->user->isGuest) : ?>
                    <?= Html::a(null, null, [
                        'id' => 'partner-follow-' . $id,
                        'class' => 'far fa-heart no-underline heart-size text-danger',
                        'data-pjax' => 0,
                    ]); ?>
                <?php endif; ?>
            </div>
            <div class="row justify-content-center justify-content-xl-end align-items-baseline mt-sm-2">
                <i class="fas fa-calendar mr-2"></i>
                <?= Yii::t('app', 'Registrado el {date}', [
                    'date' => Html::encode(Yii::$app->formatter->asDate($model->created_at)),
                ]); ?>
            </div>
            <div itemprop="url" class="row justify-content-center justify-content-xl-end align-items-baseline mt-sm-2">
                <i class="fas fa-link mr-2"></i>
                <?= Yii::$app->formatter->asUrl($model->url); ?>
            </div>
            <div itemprop="location" class="row justify-content-center justify-content-xl-end align-items-baseline mt-sm-2 mb-4">
                <div class="text-nowrap">
                    <i class="fas fa-map-marker-alt d-inline mr-2"></i>
                    <?= Html::encode($model->location) . '.'; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-xl-0 horizontal-divider"></div>
</div>