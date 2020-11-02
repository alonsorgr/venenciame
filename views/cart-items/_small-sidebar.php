<?php

/* @var $this yii\web\View */
/* @var $model app\models\CartItems */

use yii\helpers\Url;
use yii\bootstrap4\Html;

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
    <div class="row flex-nowrap">
        <div class="col-1">
            <?= Html::img(Html::encode(Url::base(true) . '/' . $model->article->link), [
                'alt' => Yii::t('app', 'Imagen del artículo'),
                'title' => Yii::t('app', 'Imagen del artículo'),
                'width' => 24,
                'data-action' => 'zoom',
            ]); ?>
        </div>
        <div class="col-3 align-self-center ml-3">
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
        <div class="col-2 align-self-center">
            <div class="d-flex justify-content-end">
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