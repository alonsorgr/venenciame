<?php

/* @var $this yii\web\View */
/* @var $reviewsModel app\models\search\ReviewsSearch */
/* @var $reviewsProvider yii\data\ActiveDataProvider */

use app\models\Articles;
use yii\bootstrap4\Html;
use yii\helpers\Url;

\yii\web\YiiAsset::register($this);

?>

<div class="article-reviews">
    <div class="row">
        <div class="col-12">
            <?= $this->render('/reviews/index', [
                'dataProvider' => $reviewsProvider
            ]); ?>
        </div>
    </div>
    <?php if (!Articles::isReview()) : ?>
        <div id="reviews-btn" class="row justify-content-center mt-5">
            <div class="col-12 col-xl-4">
                <?php if (!Yii::$app->user->isGuest) : ?>
                    <?= Html::a('<i class="fas fa-comments mr-2"></i>' . Yii::t('app', 'Agregar una reseña'), Url::to(['reviews/create']), [
                        'class' => 'show-modal-reviews-article btn btn-primary btn-block',
                        'value' => Url::to(['reviews/create']),
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-reviews-article',
                        'title' => Yii::t('app', 'Agregar una reseña')
                    ]); ?>
                <?php endif ?>
            </div>
        </div>
    <?php endif ?>
</div>