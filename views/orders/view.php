<?php

use app\helpers\Bootstrap;
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
            <div class="col d-flex justify-content-center">
                <i class="fab fa-elementor display-4 text-primary"></i>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="text-center text-md-left font-weight-bold mt-3">
                <?= Yii::t('app', 'Número de pedido'); ?>
            </div>
            <div class="text-center text-md-left mt-2">
                <?= Html::encode($model->id); ?>
            </div>
        </div>
        <div class="col-xl-7">
            <div class="text-center text-md-left font-weight-bold mt-3">
                <?= Yii::t('app', 'Estado del pedido'); ?>
            </div>
            <div class="text-center text-md-left mt-2">
                <?= Html::encode($model->status->label); ?>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="text-center text-md-right">
                <div class="text-center text-md-right font-weight-bold mt-3">
                    <?= Yii::t('app', 'Precio total'); ?>
                </div>
                <div class="text-center text-md-right mt-2">
                    <?= Html::encode(Yii::$app->formatter->asCurrency($model->total_price)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-end mt-2">
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
            <div class="collapse mt-4" id="collapseExample">
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'emptyText' => $this->render('/site/_empty'),
                    'itemView' => function ($model, $key, $index, $widget) {
                        return $this->render('/order-items/view', ['model' => $model]);
                    },
                    'layout' => '<div class="d-flex justify-content-between mb-5">{summary}{sorter}</div>{items}{pager}',
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