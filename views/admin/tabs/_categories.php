<?php

/* @var $this yii\web\View */
/* @var $categoriesSearchModel app\models\search\CategoriesSearch */
/* @var $categoriesDataProvider yii\data\ActiveDataProvider */

use yii\widgets\Pjax;
use yii\bootstrap4\Html;
use yii\widgets\ListView;
use app\helpers\Bootstrap;

\yii\web\YiiAsset::register($this);

?>

<div class="admin-categories">
    <div class="row">
        <div class="col-12 col-xl-2">
            <?= Html::a('<i class="fas fa-plus mr-2"></i>' . 'Agregar categoría', ['/categories/create'], [
                'class' => 'btn btn-primary my-5 btn-block'
            ]); ?>
        </div>
    </div>
    <?php Pjax::begin([
        'id' => 'admin-categories-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row">
        <div class="col">
            <?= $this->render('/categories/_search', [
                'model' => $categoriesSearchModel,
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <?= ListView::widget([
                'dataProvider' => $categoriesDataProvider,
                'emptyText' => $this->render('/site/_empty'),
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_categories_small', ['model' => $model]);
                },
                'layout' => '<div class="d-flex justify-content-between mb-5">{summary}{sorter}</div>{items}{pager}</div>',
                'pager' => Bootstrap::listViewPager(),
                'sorter' => [
                    'class' => 'app\widgets\DropdownSorter',
                    'label' => 'Ordenar por',
                    'attributes' => [
                        'label',
                    ],
                ],
                'options' => [
                    'class' => 'listview',
                ],
            ]); ?>
        </div>
    </div>
</div>