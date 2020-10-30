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
        <div class="col-xl-3 mb-5">
            <div class="card-border w-100">
                <div class="card-header">
                    <a id="collapse-search-articles-btn" data-toggle="collapse" href="#collapse-search-articles" aria-expanded="true" aria-controls="collapse-search-articles" id="collapse-search-articles-index" class="d-block collapse-link text-decoration-none ml-4">
                        <div class="row justify-content-between">
                            <div>
                                <i class="fas fa-search mx-2 d-inline"></i>
                                <div class="lead d-inline"><?= Yii::t('app', 'Buscar') ?></div>
                            </div>
                            <i class="collapse-icon fa fa-chevron-down mr-3 d-xl-none"></i>
                        </div>
                    </a>
                </div>
                <div id="collapse-search-articles" class="collapse d-lg-block" aria-labelledby="collapse-search-articles-index">
                    <div class="card-body px-5">
                        <?= $this->render('_search', [
                            'model' => $searchModel,
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9">
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
</article>