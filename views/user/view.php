<?php

use app\helpers\Bootstrap;
use kartik\tabs\TabsX;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $followedSearch app\models\search\FollowedSearch */
/* @var $followedProvider yii\data\ActiveDataProvider */

$this->title = $model->username;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="user-view">
    <div class="row justify-content-between">
        <div class="col-xl-8 mt-5">
            <?= $this->render('_small', [
                'model' => $model,
            ]); ?>
            <?php
            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-chart-line',
                'label' => Yii::t('app', 'Actividad'),
                'content' => $this->render('tabs/_activity.php'),
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
                'content' => $this->render('tabs/_favorites.php'),
            ]);

            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-money-check',
                'label' => Yii::t('app', 'Compras'),
                'content' => $this->render('tabs/_purchases.php'),
            ]);
            ?>
            <div class="mt-5">
                <?= TabsX::widget([
                    'id' => 'user-view-container',
                    'items' => $items,
                    'position' => TabsX::POS_ABOVE,
                    'bordered' => true,
                    'encodeLabels' => false,
                ]); ?>
            </div>
        </div>
        <div class="col-xl-3">
            <?= $this->render('_sidebar'); ?>
        </div>
    </div>
</div>