<?php

/* @var $this yii\web\View */
/* @var $model app\models\Partners */

use app\helpers\Bootstrap;
use yii\bootstrap4\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

\yii\web\YiiAsset::register($this);

?>

<div class="partners-administration">
    <div class="row">
        <div class="col-xl-6">
            <?= Html::a('<i class="fas fa-edit mr-md-2"></i>' . Yii::t('app', 'Editar información'), ['/partners/update', 'id' => $model->id], [
                'class' => 'btn btn-outline-primary btn-block mt-5',
                'title' => Yii::t('app', 'Editar información'),
            ]); ?>
        </div>
        <div class="col-xl-6">
            <?= Html::a('<i class="fas fa-plus mr-md-2"></i>' . Yii::t('app', 'Agregar nuevo producto'), ['/articles/create'], [
                'class' => 'btn btn-outline-primary btn-block mt-5',
                'title' => Yii::t('app', 'Agregar nuevo producto'),
            ]); ?>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col">
            <?= Bootstrap::header(Yii::t('app', 'Artículos pendientes de publicación')); ?>
        </div>
    </div>
    <?php Pjax::begin([
        'id' => 'partners-articles-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row">
        <div class="col-xl-12">
            <?= ListView::widget([
                'dataProvider' => $articlesProvider,
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