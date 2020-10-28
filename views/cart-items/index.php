<?php

use app\helpers\Bootstrap;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CartItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mi carrito de la compra');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partners-index">
    <?php Pjax::begin([
        'id' => 'cart-items-index-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row">
        <div class="col-xl-12">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => $this->render('/site/_empty'),
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_small', ['model' => $model]);
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
        <?php Pjax::end(); ?>
    </div>
</div>