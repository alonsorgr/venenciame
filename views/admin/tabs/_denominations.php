<?php

/* @var $this yii\web\View */
/* @var $denominationsSearchModel app\models\search\DenominationsSearch */
/* @var $denominationsDataProvider yii\data\ActiveDataProvider */

use yii\widgets\Pjax;
use yii\bootstrap4\Html;
use yii\widgets\ListView;
use app\helpers\Bootstrap;

\yii\web\YiiAsset::register($this);

?>

<div class="admin-denominations">
    <div class="row">
        <div class="col-12 col-xl-2">
            <?= Html::a('<i class="fas fa-plus mr-2"></i>' . 'Agregar denominación', ['/denominations/create'], [
                'class' => 'btn btn-primary my-5 btn-block'
            ]); ?>
        </div>
    </div>
    <?php Pjax::begin([
        'id' => 'admin-denominations-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row">
        <div class="col">
            <?= $this->render('/denominations/_search', [
                'model' => $denominationsSearchModel,
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <?= ListView::widget([
                'dataProvider' => $denominationsDataProvider,
                'emptyText' => $this->render('/site/_empty'),
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_denominations_small', ['model' => $model]);
                },
                'layout' => '<div class="d-flex justify-content-between">{summary}{sorter}</div>{items}{pager}',
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
    <?php Pjax::end(); ?>
</div>