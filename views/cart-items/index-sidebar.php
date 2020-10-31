<?php

use app\helpers\Bootstrap;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CartItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="cart-items-index-sidebar">
    <?php Pjax::begin([
        'id' => 'cart-items-index-small-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row">
        <div class="col-xl-12">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => '<div class="lead"><i class="fas fa-exclamation-circle mr-2"></i>' . Yii::t('app', 'No hay artículos en el carrito') . '</div>',
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('/cart-items/_small-sidebar', ['model' => $model]);
                },
                'layout' => '{items}{pager}',
                'pager' => Bootstrap::listViewPager(),
                'sorter' => [
                    'class' => 'app\widgets\DropdownSorter',
                    'label' => 'Ordenar por',
                    'attributes' => [
                        'created_at',
                    ],
                ],
                'options' => [
                    'class' => 'listview',
                ],
            ]); ?>
        </div>
        <div class="col-xl-12">
            <?php if ($dataProvider->totalCount != 0) : ?>
                <?= Html::a('<i class="fas fa-cart-arrow-down mr-2"></i>' . Yii::t('app', 'Realizar compra'), Url::to(['cart-items/index']), [
                    'id' => 'btn-cart',
                    'class' => 'btn btn-success btn-block',
                    'data-pjax' => 0,
                    'title' => Yii::t('app', 'Realizar compra'),
                ]); ?>
            <?php endif ?>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>