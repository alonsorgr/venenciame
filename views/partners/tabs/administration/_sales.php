<?php

/* @var $this yii\web\View */
/* @var $ordersSearch yii\data\OrdersSearch */
/* @var $ordersProvider yii\data\ActiveDataProvider */
/* @var $ordersItemsSearch yii\data\OrdersItemsSearch */
/* @var $ordersItemsProvider yii\data\ActiveDataProvider */

use app\helpers\Bootstrap;
use yii\widgets\ListView;
use yii\widgets\Pjax;

\yii\web\YiiAsset::register($this);

?>

<div class="user-orders">
    <?php Pjax::begin([
        'id' => 'user-orders-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row">
        <div class="col-xl-12 mt-5">
            <?= ListView::widget([
                'dataProvider' => $ordersProvider,
                'emptyText' => $this->render('/site/_empty'),
                'itemView' => function ($model, $key, $index, $widget) use ($orderItemsProvider) {
                    return $this->render('/orders/view', [
                        'model' => $model,
                        'dataProvider' => $orderItemsProvider,
                    ]);
                },
                'layout' => '<div class="d-flex justify-content-between mb-5">{summary}{sorter}</div>{items}{pager}',
                'pager' => Bootstrap::listViewPager(),
                'sorter' => [
                    'class' => 'app\widgets\DropdownSorter',
                    'label' => 'Ordenar por',
                    'attributes' => [
                        'created_at'
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