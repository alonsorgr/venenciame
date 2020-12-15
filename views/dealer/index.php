<?php

/* @var $this yii\web\View */
/* @var $partnersSearchModel app\models\search\PartnersSearch */
/* @var $partnersDataProvider yii\data\ActiveDataProvider */

use yii\widgets\Pjax;
use yii\bootstrap4\Html;
use yii\widgets\ListView;
use app\helpers\Bootstrap;

\yii\web\YiiAsset::register($this);

?>

<div class="dealer-orders">

    <?php Pjax::begin([
        'id' => 'dealers-orders-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row mb-3">
        <div class="col">
            <div class="text-center text-xl-left display-5"><?= Yii::t('app', 'Pedidos'); ?></div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col">
            <?= $this->render('/orders/_search_admin', [
                'model' => $ordersSearch,
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <?= ListView::widget([
                'dataProvider' => $ordersProvider,
                'emptyText' => $this->render('/site/_empty'),
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_orders_small', ['model' => $model]);
                },
                'layout' => '<div class="d-flex justify-content-between">{summary}{sorter}</div>{items}{pager}',
                'pager' => Bootstrap::listViewPager(),
                'sorter' => [
                    'class' => 'app\widgets\DropdownSorter',
                    'label' => 'Ordenar por',
                    'attributes' => [
                        'status_id',
                        'created_at'
                    ],
                ],
                'options' => [
                    'class' => 'listview',
                ],
            ]); ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>