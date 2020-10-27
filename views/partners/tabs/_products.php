<?php

/* @var $this yii\web\View */

use app\helpers\Bootstrap;
use yii\widgets\ListView;
use yii\widgets\Pjax;

\yii\web\YiiAsset::register($this);

?>

<div class="partners-products mt-5">
    <?php Pjax::begin([
        'id' => 'partners-articles-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row">
        <div class="col-xl-12">
            <?= ListView::widget([
                'dataProvider' => $articlesViewsProvider,
                'emptyText' => $this->render('/site/_empty'),
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('/articles/_small', ['model' => $model]);
                },
                'layout' => '<div class="d-flex justify-content-between mb-5">{summary}{sorter}</div>{items}{pager}',
                'pager' => Bootstrap::listViewPager(),
                'sorter' => [
                    'class' => 'app\widgets\DropdownSorter',
                    'label' => 'Ordenar por',
                    'attributes' => [
                        'title',
                        'category_id',
                        'denomination_id',
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