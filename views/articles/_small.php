<?php

use app\models\User;
use kartik\rating\StarRating;
use yii\helpers\Url;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

if (!Yii::$app->user->isGuest) {

    $this->registerJsFile('@js/notification.js');

    $notifyAddToFavorites = Yii::t('app', 'Has agregado a favoritos a {article}', [
        'article' => $model->title,
    ]);

    $notifyRemoveTofavorites = Yii::t('app', 'Has eliminado de favoritos a {article}', [
        'article' => $model->title,
    ]);

    $notifyAddToCart = Yii::t('app', 'Has agregado al carrito a {cart}', [
        'cart' => $model->title,
    ]);

    $follow = Url::to(['favorites/set', 'user_id' => User::id(), 'article_id' => $model->id]);
    $id = $model->id;

    $js = <<<EOT
    $(document).ready(function(){
        $('#article-favorite-' + $id).css('cursor', 'pointer');
        $.ajax({
            type : 'GET',
            url : '$follow',
            success: function(response) {
                response = JSON.parse(response);
                $('#article-favorite-' + $id).removeClass('far');
                $('#article-favorite-' + $id).addClass(response.class);
                $('#article-favorite-' + $id).prop('title', response.title);
            }
        });
        $('#article-favorite-' + $id).click(function(e){
            e.preventDefault();
            $.ajax({
                type : 'POST',
                url : '$follow',
                success: function(response) {
                    response = JSON.parse(response);
                    $('#article-favorite-' + $id).removeClass('fas');
                    $('#article-favorite-' + $id).addClass(response.class);
                    $('#article-favorite-' + $id).prop('title', response.title);
                    if($("#articles-favorites-pjax").length != 0) {
                        $.pjax.reload({ container: '#articles-favorites-pjax', timeout: false });
                    }
                    if($("#articles-index-pjax").length != 0) {
                        $.pjax.reload({ container: '#articles-index-pjax', timeout: false });
                    }
                    if($("#articles-favorites-pjax").length != 0) {
                        $.pjax.reload({ container: '#favorites-articles-pjax', timeout: false });
                    } 
                    if (response.class == 'fas') {
                        notification('#notifications', '$notifyAddToFavorites', 'success');
                    } else {
                        notification('#notifications', '$notifyRemoveTofavorites', 'error');
                    }
                }
            });
        });
    });
    EOT;

    $this->registerJs($js);

    $url = Url::to(['cart-items/create', 'user_id' => User::id(), 'article_id' => $model->id]);

    $js = <<<EOT
    $('#article-to-cart' + '$model->id').click(function(e){
        $.ajax({
            type : 'POST',
            url : '$url' + '&quantity=' + $('#cuantity' + '$model->id').val(),
            success: function(response) {
                response = JSON.parse(response);
                if($("#cart-items-index-small-pjax").length != 0) {
                    $.pjax.reload({ container: '#cart-items-index-small-pjax', timeout: false });
                }
                if (response.class === 'fas') {
                    notification('#notifications', '$notifyAddToCart', 'success');
                }
                $('#shopping-cart-counter').text(response.count);
            }
        });
    });
    EOT;

    $this->registerJs($js);
}
$this->registerJs("$('#cuantity' + '$model->id').inputSpinner()");

?>

<section class="articles-small">
    <div itemscope itemtype="http://schema.org/Product" class="row justify-content-start">
        <div class="col-xl-2 d-flex justify-content-center">
            <?= Html::img(Html::encode(Url::base(true) . '/' . $model->link), [
                'alt' => Yii::t('app', 'Imagen artículo'),
                'title' => Yii::t('app', 'Imagen artículo'),
                'data-action' => 'zoom',
                'itemprop' => 'image',
                'class' => 'img-article'
            ]); ?>
        </div>
        <div class="col-xl-4 pl-xl-5">
            <div class="row justify-content-center justify-content-xl-start">
                <?= Html::a(Html::encode($model->title), ['articles/view', 'id' => $model->id], [
                    'itemprop' => 'name',
                    'class' => 'display-6',
                    'data-pjax' => 0,
                ]); ?>
            </div>
            <div class="row justify-content-center justify-content-xl-start align-items-baseline mt-2">
                <div class="font-weight-bold mr-2">
                    <?= Yii::t('app', 'Disponible'); ?>
                </div>
                <?php if ($model->isAvailable()) : ?>
                    <i class="fas fa-check-circle text-success" title="<?= Yii::t('app', 'Hay artículos disponibles') ?>"></i>
                <?php else : ?>
                    <i class="fas fa-exclamation-circle text-danger" title="<?= Yii::t('app', 'No hay artículos disponibles') ?>"></i>
                <?php endif ?>
            </div>
            <div class="row justify-content-center justify-content-xl-start mt-2">
                <div class="d-block text-center text-xl-left">
                    <div class="font-weight-bold">
                        <?= Yii::t('app', 'Bodega'); ?>
                    </div>
                    <?= Html::a(Html::encode($model->partner->name), ['partners/view', 'id' => $model->partner->id], [
                        'itemprop' => 'manufacturer',
                        'data-pjax' => 0,
                    ]); ?>
                </div>
            </div>
            <div class="row justify-content-center justify-content-xl-start mt-2">
                <div class="d-block text-center text-xl-left">
                    <div class="font-weight-bold">
                        <?= Yii::t('app', 'Tipo'); ?>
                    </div>
                    <?= Html::encode($model->category->label); ?>
                </div>
            </div>
            <div class="row justify-content-center justify-content-xl-start mt-3">
                <div class="d-block text-center text-xl-left">
                    <div itemprop="" class="display-5 d-inline font-weight-bold">
                        <?= Html::encode(Yii::$app->formatter->asCurrency($model->amount)); ?>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center justify-content-xl-start mt-2">
                <div class="d-block text-center text-xl-left">
                    <?= Html::encode(Yii::$app->formatter->asCurrency($model->price)) . ' sin ' . Html::encode($model->vat->label); ?>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="row justify-content-center justify-content-xl-end mt-2 pr-xl-3">
                <?php if (!Yii::$app->user->isGuest) : ?>
                    <?= Html::a(null, null, [
                        'id' => 'article-favorite-' . $model->id,
                        'class' => 'far fa-star no-underline heart-size text-warning',
                        'data-pjax' => 0,
                        'title' => Yii::t('app', 'Agregar a favoritos')
                    ]); ?>
                <?php endif ?>
            </div>
            <div class="row justify-content-center justify-content-xl-end mt-3 pr-xl-3">
                <div class="d-block text-center text-xl-right">
                    <div class="font-weight-bold">
                        <?= Yii::t('app', 'Valoración') ?>
                    </div>
                    <div style="margin-right: -3px;">
                        <?= StarRating::widget([
                            'id' => 'total-score' . $model->id,
                            'name' => 'rating-article',
                            'value' => $model->score,
                            'pluginOptions' => [
                                'min' => 0,
                                'max' => 5,
                                'step' => 1,
                                'size' => 'xs',
                                'readonly' => true,
                                'theme' => 'krajee-svg',
                                'showClear' => false,
                                'showCaption' => false,
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center justify-content-xl-end mt-2 pr-xl-3">
                <div class="d-block text-center text-xl-right">
                    <div class="font-weight-bold">
                        <?= Yii::t('app', 'Capacidad'); ?>
                    </div>
                    <?= Html::encode($model->capacity) . ' cl.'; ?>
                </div>
            </div>
            <div class="row justify-content-center justify-content-xl-end mt-2 pr-xl-3">
                <div class="d-block text-center text-xl-right">
                    <div class="font-weight-bold">
                        <?= Yii::t('app', 'Denominación de origen'); ?>
                    </div>
                    <?= Html::encode($model->denomination->label); ?>
                </div>
            </div>
            <div class="row justify-content-center justify-content-xl-end mt-4">
                <div class="col-3 col-xl-5 mb-0">
                    <div class="text-center text-xl-right" style="z-index: 100;">
                        <?= Html::input('number', 'quantity', 1, [
                            'id' => 'cuantity' . $model->id,
                            'min' => 1,
                            'max' => $model->stock,
                            'class' => 'form-control',
                            'placeholder' => Yii::t('app', 'Uds.'),
                            'title' => Yii::t('app', 'Seleccione el número de unidades'),
                        ]) ?>
                    </div>
                </div>
                <div class="col-xl-7 mt-4 mt-xl-0">
                    <?= Html::a('<i class="fas fa-cart-plus mr-2"></i>' . Yii::t('app', 'Agregar al carrito'), null, [
                        'id' => 'article-to-cart' . $model->id,
                        'class' => 'btn btn-primary btn-block',
                        'data-pjax' => 0,
                        'title' => Yii::t('app', 'Agregar artículo al carrito'),
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="horizontal-divider"></div>
</section>