<?php

use app\helpers\Bootstrap;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PartnersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Socios');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partners-index">
    <?php Pjax::begin([
        'id' => 'partners-index-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row justify-content-between">
        <div class="col-xl-8">
            <div>
                <?php $form = ActiveForm::begin([
                    'action' => ['/user/search'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]); ?>
                <div class="mb-4">
                    <?= $form->field($searchModel, 'name')->textInput([
                        'maxlength' => true,
                        'placeholder' => Yii::t('app', 'Buscar por nombre de la empresa o bodega'),
                        'title' => Yii::t('app', 'Buscar por nombre de la empresa o bodega'),
                    ]); ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
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
                        'name',
                        'city',
                        'country_id',
                        'state_id',
                    ],
                ],
                'options' => [
                    'class' => 'listview',
                ],
            ]); ?>
        </div>
        <div class="col-xl-3">
            <?= $this->render('_search', [
                'model' => $searchModel,
            ]); ?>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>