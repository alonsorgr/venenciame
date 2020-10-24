<?php

use app\models\User;
use kartik\rating\StarRating;
use yii\helpers\Url;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

if (!Yii::$app->user->isGuest) {

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
                    if($("#favorites-articles-pjax").length != 0) {
                        $.pjax.reload({ container: '#favorites-articles-pjax', timeout: false });
                    } 
                }
            });
        });
    });
    EOT;

    $this->registerJs($js);
}

?>

<section class="articles-small">
    <div itemscope itemtype="http://schema.org/Product" class="row">
        <div class="col-sm-12 col-xl-3 d-flex justify-content-center">
            <?= Html::img(Html::encode(Url::base(true) . '/' . $model->link), [
                'alt' => Yii::t('app', 'Logo corporativo'),
                'title' => Yii::t('app', 'Logo corporativo'),
                'data-action' => 'zoom',
                'itemprop' => 'image',
                'class' => 'img-fluid'
            ]); ?>
        </div>
        <div class="col-sm-12 col-xl-9">
            <div class="row justify-content-md-between justify-content-center mb-3">
                <div class="col-12 col-md-8 text-center text-md-left">
                    <?= Html::a(Html::encode($model->title), ['articles/view', 'id' => $model->id], [
                        'itemprop' => 'name',
                        'class' => 'display-5',
                        'data-pjax' => 0,
                    ]) ?>
                </div>
                <?php if (!Yii::$app->user->isGuest) : ?>
                    <?= Html::a(null, null, [
                        'id' => 'article-favorite-' . $model->id,
                        'class' => 'far fa-star no-underline heart-size text-warning pr-md-3 pt-md-3',
                        'data-pjax' => 0,
                        'title' => Yii::t('app', 'Agregar a favoritos')
                    ]); ?>
                <?php endif ?>
            </div>
            <div class="row justify-content-md-between justify-content-center mb-3">
                <div class="col-12 col-md-8 text-center text-md-left">
                    <div class="font-weight-bold">
                        <?= Yii::t('app', 'Stock') ?>
                    </div>
                    <?php if ($model->isAvailable()) : ?>
                        <i class="fas fa-check-circle text-success mt-2" title="<?= Yii::t('app', 'Hay artículos disponibles') ?>"></i>
                    <?php else : ?>
                        <i class="fas fa-exclamation-circle text-danger" title="<?= Yii::t('app', 'No hay artículos disponibles') ?>"></i>
                    <?php endif ?>
                </div>
                <div class="col-12 col-md-4 text-center text-md-right">
                    <div class="font-weight-bold">
                        <?= Yii::t('app', 'Valoración') ?>
                    </div>
                    <?= StarRating::widget([
                        'name' => 'rating',
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
            <div class="row justify-content-md-between justify-content-center mt-xl-3">
                <div class="col-12 col-md-8 text-center text-md-left">
                    <div class="font-weight-bold">
                        <?= Yii::t('app', 'Bodega') ?>
                    </div>
                    <?= Html::a(Html::encode($model->partner->name), ['partners/view', 'id' => $model->partner->id], [
                        'itemprop' => 'manufacturer',
                        'data-pjax' => 0,
                    ]); ?>
                </div>
                <div class="col-12 col-md-4 text-center text-md-right">
                    <div class="font-weight-bold">
                        <?= Yii::t('app', 'Capacidad') ?>
                    </div>
                    <?= Html::encode($model->capacity) . ' cl.'; ?>
                </div>
            </div>
            <div class="row justify-content-md-between justify-content-center mt-xl-3">
                <div class="col-12 col-md-8 text-center text-md-left">
                    <div itemprop="category" class="font-weight-bold">
                        <?= Yii::t('app', 'Tipo de vino') ?>
                    </div>
                    <?= Html::encode($model->category->label); ?>
                </div>
                <div class="col-12 col-md-4 text-center text-md-right">
                    <div itemprop="category" class="font-weight-bold">
                        <?= Yii::t('app', 'Denominación de origen') ?>
                    </div>
                    <?= Html::encode($model->denomination->label); ?>
                </div>
            </div>
            <div class="row justify-content-md-between justify-content-center mt-xl-3">
                <div class="col-12 col-md-7 text-center text-md-left">
                    <div itemprop="" class="display-6 d-inline font-weight-bold">
                        <?= Html::encode(Yii::$app->formatter->asCurrency($model->amount)); ?>
                    </div>
                    <div class="mt-2">
                        <?= Html::encode(Yii::$app->formatter->asCurrency($model->price)) . ' sin ' . Html::encode($model->vat->label); ?>
                    </div>
                </div>
                <div class="col-12 col-md-5 text-center text-md-right mt-2">
                    <div class="row justify-content-md-end justify-content-center">
                        <div class="col-md-12 text-center text-md-right">
                            <?= Html::a('<i class="fas fa-cart-plus mr-2"></i>' . Yii::t('app', 'Agregar al carrito'), ['/carts/create'], [
                                'class' => 'btn btn-primary btn-block'
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="horizontal-divider"></div>
</section>