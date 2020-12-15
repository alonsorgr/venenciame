<?php

use app\helpers\Bootstrap;
use app\models\User;
use kartik\tabs\TabsX;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $followedSearch app\models\search\FollowedSearch */
/* @var $followedProvider yii\data\ActiveDataProvider */
/* @var $favoritesSearch yii\data\FavoritesSearch*/
/* @var $favoritesProvider yii\data\ActiveDataProvider */
/* @var $reviewsSearch yii\data\ReviewsSearch */
/* @var $reviewsProvider yii\data\ActiveDataProvider */
/* @var $ordersSearch yii\data\OrdersSearch */
/* @var $ordersProvider yii\data\ActiveDataProvider */
/* @var $ordersItemsSearch yii\data\OrdersItemsSearch */
/* @var $ordersItemsProvider yii\data\ActiveDataProvider */

$this->title = $model->username;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="user-view">
    <div class="row justify-content-between">
        <div class="col-xl-12 mt-5">
            <?= $this->render('_small', [
                'model' => $model,
            ]); ?>
            <?php
            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-chart-line',
                'label' => Yii::t('app', 'Actividad'),
                'content' => $this->render('tabs/_activity.php', [
                    'reviewsSearch' => $reviewsSearch,
                    'reviewsProvider' => $reviewsProvider,
                ]),
            ]);

            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-heart',
                'label' => Yii::t('app', 'Seguidos'),
                'content' => $this->render('tabs/_followed.php', [
                    'followedSearch' => $followedSearch,
                    'followedProvider' => $followedProvider,
                ]),
            ]);

            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-star',
                'label' => Yii::t('app', 'Favoritos'),
                'content' => $this->render('tabs/_favorites.php', [
                    'favoritesSearch' => $favoritesSearch,
                    'favoritesProvider' => $favoritesProvider,
                ]),
            ]);
            if ($model->isOwner() || User::isAdmin()) {
                $items[] = Bootstrap::tabItem([
                    'icon' => 'fas fa-money-check',
                    'label' => Yii::t('app', 'Compras'),
                    'content' => $this->render('tabs/_orders.php', [
                        'ordersSearch' => $ordersSearch,
                        'ordersProvider' => $ordersProvider,
                        'orderItemsSearch' => $orderItemsSearch,
                        'orderItemsProvider' => $orderItemsProvider,
                    ]),
                ]);
            }
            ?>
            <div class="mt-5">
                <?= TabsX::widget([
                    'id' => $model->isOwner() || User::isAdmin() ? 'user-view-container' : 'user-view-container-login',
                    'items' => $items,
                    'position' => TabsX::POS_ABOVE,
                    'bordered' => true,
                    'encodeLabels' => false,
                ]); ?>
            </div>
        </div>
    </div>
</div>