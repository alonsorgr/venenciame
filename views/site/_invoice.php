<?php

/* @var $this yii\web\View */
/* @var $model app\models\forms\CartItems */

use app\helpers\Bootstrap;
use yii\bootstrap4\Html;

$this->title = Yii::t('app', 'Factura de compra');

?>
<div class="site-invoice">
    <div class="card-border">
        <div class="card-header pt-4">
            <div class="row">
                <div class="col-12">
                    <?= Bootstrap::header(Yii::t('app', 'Factura de compra')) ?>
                </div>
            </div>
        </div>
        <div class="card-body my-4">
            <div class="row">
                <div class="col-12">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col"><?= Yii::t('app', 'Artículo') ?></th>
                                <th scope="col"><?= Yii::t('app', 'Cantidad') ?></th>
                                <th class="text-right" scope="col"><?= Yii::t('app', 'Precio') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0; ?>
                            <?php foreach ($model as $value) : ?>
                                <tr>
                                    <td class="py-3"><?= Html::encode($value->article->title) ?></td>
                                    <td class="py-3"><?= Html::encode($value['quantity']) ?></td>
                                    <td class="text-right py-3"><?= Html::encode(Yii::$app->formatter->asCurrency(($value->article->price * $value->article->vat->value / 100) + $value->article->price)) ?></td>
                                </tr>
                                <?php $total += (($value->article->price * $value->article->vat->value / 100) + $value->article->price) * $value['quantity']; ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-2">
                    <?= Yii::t('app', 'Total') ?>
                </div>
                <div class="col-10 text-right">
                    <?= Html::encode(Yii::$app->formatter->asCurrency($total)) ?>
                </div>
            </div>
        </div>
    </div>
</div>