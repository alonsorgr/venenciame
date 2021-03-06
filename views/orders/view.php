<?php

use app\helpers\Bootstrap;
use app\models\Status;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */

\yii\web\YiiAsset::register($this);
?>
<div class="orders-view">
    <div class="row">
        <div class="col-xl-1">
            <div class="col d-flex justify-content-center align-items-center">
                <i class="fas fa-truck-moving text-primary fa-4x"></i>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="text-center text-xl-left font-weight-bold mt-2">
                <?= Yii::t('app', 'Número de pedido'); ?>
            </div>
            <div class="text-center text-xl-left mt-2">
                <?= Html::encode($model->id); ?>
            </div>
        </div>
        <div class="col-xl-7">
            <div class="text-center text-xl-left font-weight-bold mt-2">
                <?= Yii::t('app', 'Estado del pedido'); ?>
            </div>
            <div class="text-center text-xl-left mt-2">
                <?= Html::encode($model->status->label); ?>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="text-center text-xl-right">
                <div class="text-center text-xl-right font-weight-bold mt-2">
                    <?= Yii::t('app', 'Precio total'); ?>
                </div>
                <div class="text-center text-xl-right mt-2">
                    <?= Html::encode(Yii::$app->formatter->asCurrency($model->total_price)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="my-xl-3 horizontal-divider"></div>
    <div class="row justify-content-end">
        <div class="col-xl-12 d-flex justify-content-end">
            <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="collapse-icon fa fa-chevron-down"></i>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php Pjax::begin([
                'id' => 'cart-items-index-pjax',
                'timeout' => '100000',
            ]); ?>
            <div class="collapse" id="collapseExample">
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'emptyText' => $this->render('/site/_empty'),
                    'itemView' => function ($model, $key, $index, $widget) {
                        return $this->render('/order-items/view', ['model' => $model]);
                    },
                    'layout' => '<div class="d-flex justify-content-between"></div>{items}{pager}',
                    'pager' => Bootstrap::listViewPager(),
                    'sorter' => [
                        'class' => 'app\widgets\DropdownSorter',
                        'label' => 'Ordenar por',
                        'attributes' => [
                            'article_id',
                            'order_id',
                            'quantity',
                            'price',
                        ],
                    ],
                    'options' => [
                        'class' => 'listview',
                    ],
                ]); ?>
            </div>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>