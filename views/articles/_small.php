<?php

use app\models\User;
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
        <div class="col-sm-12 col-xl-3 d-flex justify-content-xl-start justify-content-center">
            <div class="article-box mt-md-5 mt-sm-1">
                <div class="image-article">
                    <?= Html::img(Html::encode(Url::base(true) . '/' . $model->link), [
                        'alt' => Yii::t('app', 'Logo corporativo'),
                        'title' => Yii::t('app', 'Logo corporativo'),
                        'data-action' => 'zoom',
                        'itemprop' => 'image',
                    ]); ?>
                </div>
            </div>
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
                <div class="col-12 col-md-12 text-center text-md-left">
                    <div itemprop="description" class="font-weight-bold">
                        <?= Yii::t('app', 'Descripción') ?>
                    </div>
                    <?= Html::encode($model->description) ?>
                </div>
            </div>
            <div class="row justify-content-md-between justify-content-center mb-3">
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
            <div class="row justify-content-md-between justify-content-center mb-3">
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
            <div class="row justify-content-md-between justify-content-center mb-3 mt-xl-5">
                <div class="col-12 col-md-8 text-center text-md-left">
                    <div itemprop="" class="display-6 d-inline font-weight-bold">
                        <?= Html::encode(Yii::$app->formatter->asCurrency($model->amount)); ?>
                    </div>
                    <div class="mt-2">
                        <?= Html::encode(Yii::$app->formatter->asCurrency($model->price)) . ' sin ' . Html::encode($model->vat->label); ?>
                    </div>
                </div>
                <div class="col-12 col-md-4 text-center text-md-right">
                    <div class="font-weight-bold">
                        <?= Yii::t('app', 'Disponibilidad') ?>
                    </div>
                    <?php if ($model->isAvailable()) : ?>
                        <i class="fas fa-check-circle text-success" title="<?= Yii::t('app', 'Hay artículos disponibles') ?>"></i>
                    <?php else : ?>
                        <i class="fas fa-exclamation-circle text-danger" title="<?= Yii::t('app', 'No hay artículos disponibles') ?>"></i>
                    <?php endif ?>
                </div>
            </div>
            <div class="row justify-content-md-end justify-content-center mb-4">
                <div class="col-xl-4 col-md-12 text-center text-md-right">
                    <?= Html::a('<i class="fas fa-cart-plus mr-2"></i>' . Yii::t('app', 'Agregar al carrito'), ['/carts/create'], [
                        'class' => 'btn btn-primary btn-block'
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-xl-1 horizontal-divider"></div>
</section>