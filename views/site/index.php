<?php

/* @var $this yii\web\View */

use app\helpers\Bootstrap;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = Yii::$app->name;
?>
<div class="site-index">
    <div class="row">
        <div class="col-12 text-center">
            <div class="display-4"><?= Yii::t('app', 'Venénciame') ?></div>
        </div>
        <div class="col-12 text-center">
            <div class="lead font-italic"><?= Yii::t('app', 'Vinos de las mejores bodegas del marco de Jeréz') ?></div>
        </div>
    </div>
    <?php Pjax::begin([
        'id' => 'articles-index-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row">
        <div class="col">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
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
                        'partner_id',
                        'category_id',
                        'denomination_id',
                        'price',
                        'degrees',
                    ],
                ],
                'options' => [
                    'class' => 'listview',
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>