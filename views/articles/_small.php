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
                    if($("#articles-favorites-pjax").length != 0) {
                        $.pjax.reload({ container: '#favorites-articles-pjax', timeout: false });
                    } 
                }
            });
        });
    });
    EOT;

    $this->registerJs($js);
}
$this->registerJs("$('#cuantity' + '$model->id').inputSpinner()");

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
            <div class="row justify-content-xl-between justify-content-center mb-3">
                <div class="col-12 col-xl-8 text-center text-xl-left">
                    <?= Html::a(Html::encode($model->title), ['articles/view', 'id' => $model->id], [
                        'itemprop' => 'name',
                        'class' => 'display-5',
                        'data-pjax' => 0,
                    ]) ?>
                </div>
                <?php if (!Yii::$app->user->isGuest) : ?>
                    <?= Html::a(null, null, [
                        'id' => 'article-favorite-' . $model->id,
                        'class' => 'far fa-star no-underline heart-size text-warning pr-xl-3 pt-xl-3',
                        'data-pjax' => 0,
                        'title' => Yii::t('app', 'Agregar a favoritos')
                    ]); ?>
                <?php endif ?>
            </div>
            <div class="row justify-content-xl-between justify-content-center mb-3">
                <div class="col-12 col-xl-8 text-center text-xl-left">
                    <div class="font-weight-bold">
                        <?= Yii::t('app', 'Stock') ?>
                    </div>
                    <?php if ($model->isAvailable()) : ?>
                        <i class="fas fa-check-circle text-success mt-2" title="<?= Yii::t('app', 'Hay artículos disponibles') ?>"></i>
                    <?php else : ?>
                        <i class="fas fa-exclamation-circle text-danger" title="<?= Yii::t('app', 'No hay artículos disponibles') ?>"></i>
                    <?php endif ?>
                </div>
                <div class="col-12 col-xl-4 text-center text-xl-right">
                    <div class="font-weight-bold">
                        <?= Yii::t('app', 'Valoración') ?>
                    </div>
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
            <div class="row justify-content-xl-between justify-content-center mt-xl-3">
                <div class="col-12 col-xl-8 text-center text-xl-left">
                    <div class="font-weight-bold">
                        <?= Yii::t('app', 'Bodega') ?>
                    </div>
                    <?= Html::a(Html::encode($model->partner->name), ['partners/view', 'id' => $model->partner->id], [
                        'itemprop' => 'manufacturer',
                        'data-pjax' => 0,
                    ]); ?>
                </div>
                <div class="col-12 col-xl-4 text-center text-xl-right">
                    <div class="font-weight-bold">
                        <?= Yii::t('app', 'Capacidad') ?>
                    </div>
                    <?= Html::encode($model->capacity) . ' cl.'; ?>
                </div>
            </div>
            <div class="row justify-content-xl-between justify-content-center mt-xl-3">
                <div class="col-12 col-xl-8 text-center text-xl-left">
                    <div itemprop="category" class="font-weight-bold">
                        <?= Yii::t('app', 'Tipo de vino') ?>
                    </div>
                    <?= Html::encode($model->category->label); ?>
                </div>
                <div class="col-12 col-xl-4 text-center text-xl-right">
                    <div itemprop="category" class="font-weight-bold">
                        <?= Yii::t('app', 'Denominación de origen') ?>
                    </div>
                    <?= Html::encode($model->denomination->label); ?>
                </div>
            </div>
            <div class="row justify-content-xl-between justify-content-center mt-xl-3">
                <div class="col-12 col-xl-4 text-center text-xl-left">
                    <div itemprop="" class="display-6 d-inline font-weight-bold">
                        <?= Html::encode(Yii::$app->formatter->asCurrency($model->amount)); ?>
                    </div>
                    <div class="mt-2">
                        <?= Html::encode(Yii::$app->formatter->asCurrency($model->price)) . ' sin ' . Html::encode($model->vat->label); ?>
                    </div>
                </div>
                <div class="col-12 col-xl-8 text-center text-xl-right mt-2">
                    <div class="row justify-content-xl-end justify-content-center">
                        <div class="col-xl-5 text-center text-xl-right" style="z-index: 100;">
                            <?= Html::input('number', 'cuantity', '', [
                                'id' => 'cuantity' . $model->id,
                                'min' => 1,
                                'max' => $model->stock,
                                'class' => 'form-control',
                                'placeholder' => Yii::t('app', 'Uds.'),
                                'title' => Yii::t('app', 'Seleccione el número de unidades'),
                            ]) ?>
                        </div>
                        <div class="col-xl-7 text-center text-xl-right mt-4 mt-xl-0">
                            <?= Html::a('<i class="fas fa-cart-plus mr-2"></i>' . Yii::t('app', 'Agregar al carrito'), ['/carts/create'], [
                                'class' => 'btn btn-primary btn-block',
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="horizontal-divider"></div>
</section>