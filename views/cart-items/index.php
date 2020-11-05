<?php

use app\helpers\Bootstrap;
use yii\bootstrap4\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CartItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mi carrito de la compra');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-items-index">
    <?php Pjax::begin([
        'id' => 'cart-items-index-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row">
        <div class="col-xl-12 display-5 mb-4">
            <?= Yii::t('app', 'Artículos en el carrito'); ?>
        </div>
        <div class="col-xl-12">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => $this->render('/site/_empty'),
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('/cart-items/_small', ['model' => $model]);
                },
                'layout' => '<div class="d-flex justify-content-between mb-5">{summary}{sorter}</div>{items}{pager}',
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
    </div>
    <div class="row">
        <div class="col-xl-12">
            <?= Bootstrap::header(Yii::t('app', 'Total del carrito')); ?>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-9 col-xl-5">
            <?= Yii::t('app', 'Total'); ?>
        </div>
        <div class="col-3 col-xl-3 text-right font-weight-bold display-6">
            <?= Html::encode(Yii::$app->formatter->asCurrency($total)); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8">
            <div class="horizontal-divider mt-1"></div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-xl-4">
            <?= Html::a('<i class="fas fa-credit-card mr-2"></i>' . Yii::t('app', 'Pasar por caja'), null, [
                'class' => 'btn btn-success btn-block',
                'data-pjax' => 0,
                'title' => Yii::t('app', 'Pasar por caja'),
            ]); ?>
        </div>
        <div class="col-xl-4 mt-sm-3 mt-xl-0">
            <?= Html::a('<i class="fas fa-undo-alt mr-2"></i>' . Yii::t('app', 'Seguir comprando'), ['articles/index'], [
                'class' => 'btn btn-outline-primary btn-block',
                'data-pjax' => 0,
                'title' => Yii::t('app', 'Seguir comprando'),
            ]); ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>