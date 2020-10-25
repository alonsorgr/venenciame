<?php

/* @var $this yii\web\View */
/* @var $reviewsModel app\models\search\ReviewsSearch */
/* @var $reviewsProvider yii\data\ActiveDataProvider */

use app\models\Reviews;
use yii\bootstrap4\Html;
use yii\helpers\Url;

\yii\web\YiiAsset::register($this);

?>

<div class="article-reviews">
    <div class="row mt-5">
        <div class="col-12 col-xl-4">
            <?php if (!Yii::$app->user->isGuest) : ?>
                <?= Html::a('<i class="fas fa-comment mr-2"></i>' . Yii::t('app', 'Agregar una reseña'), Url::to(['reviews/create']), [
                    'data-method' => 'POST',
                    'class' => 'btn btn-primary btn-block',
                    'title' => Yii::t('app', 'Eliminar')
                ]) ?>
            <?php endif ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?= $this->render('/reviews/index', [
                'dataProvider' => $reviewsProvider
            ]); ?>
        </div>
    </div>
</div>