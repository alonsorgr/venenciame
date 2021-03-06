<?php

use app\helpers\Bootstrap;
use app\models\User;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Vinos');
//$this->params['breadcrumbs'][] = $this->title;
?>
<article class="articles-index">
    <?php Pjax::begin([
        'id' => 'articles-index-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row">
        <div class="col-xl-4 mb-5">
            <div class="card-border">
                <div class="card-header">
                    <a id="collapse-search-articles-btn" data-toggle="collapse" href="#collapse-search-articles" aria-expanded="true" aria-controls="collapse-search-articles" id="collapse-search-articles-index" class="d-block collapse-link text-decoration-none ml-3">
                        <div class="row justify-content-between">
                            <div>
                                <i class="fas fa-search d-inline mr-2" style="color: #3B525A"></i>
                                <div class="lead d-inline lead"><?= Yii::t('app', 'Buscar') ?></div>
                            </div>
                            <i class="collapse-icon fa fa-chevron-down mr-3 d-xl-none"></i>
                        </div>
                    </a>
                </div>
                <div id="collapse-search-articles" class="collapse d-xl-block" aria-labelledby="collapse-search-articles-index">
                    <div class="card-body">
                        <?= $this->render('_search', [
                            'model' => $searchModel,
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <?php if ($dataProvider->totalCount != 0) : ?>
                <div class="row mb-3">
                    <div class="col">
                        <div class="text-center text-xl-left display-5"><?= Yii::t('app', 'Todos los vinos'); ?></div>
                    </div>
                </div>
            <?php endif ?>
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
        </div>
        <?php Pjax::end(); ?>
    </div>
</article>