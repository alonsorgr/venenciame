<?php

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

use yii\helpers\Url;
use yii\bootstrap4\Html;
use app\helpers\Bootstrap;

$this->title = Yii::t('app', 'Desconectarse');

?>
<div class="articles-delete">
    <div class="row">
        <div class="col mt-3 mx-3">
            <div class="lead">
                <?= Yii::t('app', '¿Desea eliminar el artículo {article}?', [
                    'article' => $model->title,
                ]) ?>
            </div>
        </div>
    </div>
    <div class="row justify-content-end my-3 mx-3">
        <?= Html::a(Yii::t('app', 'Eliminar'), Url::to(['articles/delete', 'id' => $model->id]), [
            'data-method' => 'POST',
            'class' => 'btn btn-danger',
            'title' => Yii::t('app', 'Eliminar')
        ]) ?>
    </div>
</div>