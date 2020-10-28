<?php

use yii\helpers\Url;
use yii\bootstrap4\Html;
use app\helpers\Bootstrap;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */


$this->title = Yii::t('app', 'Eliminar del carrito');

?>
<div class="articles-delete">
    <div class="row">
        <div class="col mt-3 mx-3">
            <div class="lead">
                <?= Yii::t('app', '¿Desea eliminar el artículo {article}?', [
                    'article' => $model->article->title,
                ]) ?>
            </div>
        </div>
    </div>
    <div class="row justify-content-end my-3 mx-3">
        <?= Html::a(Yii::t('app', 'Eliminar'), Url::to(['cart-items/delete', 'id' => $model->id]), [
            'id' => 'cart-items-delete',
            'data-method' => 'POST',
            'class' => 'btn btn-danger',
            'title' => Yii::t('app', 'Eliminar')
        ]) ?>
    </div>
</div>