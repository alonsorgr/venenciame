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

<div class="admin-articles">
    <div class="row">
        <div class="col-12 col-xl-2">
            <?= Html::a('<i class="fas fa-plus mr-2"></i>' . Yii::t('app', 'Agregar un artículo'), ['/articles/create'], [
                'class' => 'btn btn-primary my-5 btn-block'
            ]); ?>
        </div>
    </div>
    <?php Pjax::begin([
        'id' => 'admin-articles-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row">
        <div class="col">
            <?= $this->render('/articles/_search_admin', [
                'model' => $articlesSearchModel,
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <?= ListView::widget([
                'dataProvider' => $articlesDataProvider,
                'emptyText' => $this->render('/site/_empty'),
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_articles_small', ['model' => $model]);
                },
                'layout' => '<div class="d-flex justify-content-between">{summary}{sorter}</div>{items}{pager}',
                'pager' => Bootstrap::listViewPager(),
                'sorter' => [
                    'class' => 'app\widgets\DropdownSorter',
                    'label' => 'Ordenar por',
                    'attributes' => [
                        'title',
                        'partner_id',
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