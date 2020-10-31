<?php

/* @var $this yii\web\View */
/* @var $cartItemsSearchModel app\models\search\CartItemsSearch */
/* @var $cartItemsProvider yii\data\ActiveDataProvider */

use yii\bootstrap4\Html;
use yii\helpers\Url;

$url = Url::to(['cart-items/delete', 'id' => $model->id]);

$js = <<<EOT
    $('#cart-items-delete' + '$model->id').click(function(e){
        $.ajax({
            type : 'POST',
            url : '$url',
            success: function(response) {
                response = JSON.parse(response);
                if($("#cart-items-index-small-pjax").length != 0) {
                    $.pjax.reload({ container: '#cart-items-index-small-pjax', timeout: false });
                }
            }
        });
    });
EOT;

$this->registerJs($js);

\yii\web\YiiAsset::register($this);

?>

<div class="cart-items-small-sidebar">
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <?= Html::a(Html::encode($model->article->title), ['articles/view', 'id' => $model->article->id], [
                    'title' => Html::encode($model->article->title),
                    'data-pjax' => 0,
                ]); ?>
            </div>
        </div>
    </div>
    <div class="row justify-content-start">
        <div class="col-2">
            <?= Html::img(Html::encode(Url::base(true) . '/' . $model->article->link), [
                'alt' => Yii::t('app', 'Imagen del artículo'),
                'title' => Yii::t('app', 'Imagen del artículo'),
                'width' => 32,
                'data-action' => 'zoom',
            ]); ?>
        </div>
        <div class="col-3 align-self-center">
            <div class="font-weight-bold d-inline">
                <?= Yii::t('app', 'Uds:'); ?>
            </div>
            <div class="d-inline">
                <?= Html::encode(Yii::$app->formatter->asInteger($model->quantity)); ?>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <div class="font-weight-bold d-inline">
                <?= Yii::t('app', 'Total:'); ?>
            </div>
            <div class="d-inline">
                <?= Html::encode(Yii::$app->formatter->asCurrency($model->article->amount * $model->quantity)); ?>
            </div>
        </div>
        <div class="col-1 align-self-center">
            <div class="">
                <?= Html::a(null, null, [
                    'id' => 'cart-items-delete' . $model->id,
                    'class' => 'fas fa-trash no-underline cursor-pointer text-danger',
                    'data-pjax' => 0,
                    'title' => Yii::t('app', 'Eliminar artículo del carrito'),
                ]); ?>
            </div>
        </div>
    </div>
    <div class="my-xl-3 horizontal-divider"></div>
</div>