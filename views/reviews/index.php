<?php

use app\helpers\Bootstrap;
use app\models\Reviews;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ReviewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="reviews-index">
    <?php Pjax::begin([
        'id' => 'reviews-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row">
        <div class="col-xl-12 mt-5">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => $this->render('/site/_empty'),
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('/reviews/_small', ['model' => $model]);
                },
                'layout' => '<div class="d-flex justify-content-between mb-5">{summary}{sorter}</div>{items}{pager}',
                'pager' => Bootstrap::listViewPager(),
                'sorter' => [
                    'class' => 'app\widgets\DropdownSorter',
                    'label' => 'Ordenar por',
                    'attributes' => [
                        'score',
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
<?php Bootstrap::modal([
    'id' => 'modal-reviews-article',
    'image' => 'fas fa-comments',
    'size' => 'modal-lg',
    'title' => Yii::t('app', 'Agregar una reseña'),
]) ?>