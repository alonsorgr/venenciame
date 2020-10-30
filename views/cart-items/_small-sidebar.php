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
    <div class="row mb-2">
        <div class="col-12">
            <div class="mx-auto">
                <div class="lead text-center text-md-left mb-2">
                    <?= Html::a(Html::encode($model->article->title), ['articles/view', 'id' => $model->article->id], [
                        'style' => 'text-overflow: ellipsis; overflow:hidden; white-space:nowrap;',
                        'data-pjax' => 0,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-start">
        <div class="col-4">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Uds'); ?>
                </div>
                <div class="text-center text-md-left mt-2">
                    <?= Html::encode(Yii::$app->formatter->asInteger($model->quantity)); ?>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="mx-auto">
                <div class="text-center text-md-left font-weight-bold">
                    <?= Yii::t('app', 'Total'); ?>
                </div>
                <div class="text-center text-md-left mt-2">
                    <?= Html::encode(Yii::$app->formatter->asCurrency($model->article->amount * $model->quantity)); ?>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="mx-auto">
                <div class="d-flex justify-content-end text-center font-weight-bold mb-2">
                    <?= Yii::t('app', 'Acciones'); ?>
                </div>
                <div class="d-flex justify-content-end" style="margin-top: 10px;">
                    <?= Html::a(null, null, [
                        'id' => 'cart-items-delete' . $model->id,
                        'class' => 'fas fa-trash no-underline cursor-pointer text-danger',
                        'data-pjax' => 0,
                        'title' => Yii::t('app', 'Eliminar artículo del carrito'),
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="my-xl-3 horizontal-divider"></div>
</div>