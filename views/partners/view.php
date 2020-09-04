<?php

use app\helpers\Bootstrap;
use yii\helpers\Url;
use yii\bootstrap4\Html;
use app\models\User;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model app\models\Partners */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Socios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="partners-view">
    <div class="row justify-content-between">
        <div class="col-xl-8">
            <div class="row mt-5">
                <div class="col-12">
                    <?= $this->render('_small', [
                        'model' => $model,
                    ]); ?>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <?php
                    $items[] = Bootstrap::tabItem([
                        'icon' => 'fas fa-chart-line',
                        'label' => Yii::t('app', 'Productos'),
                        'content' => $this->render('tabs/_products.php'),
                    ]);

                    $items[] = Bootstrap::tabItem([
                        'icon' => 'fas fa-heart',
                        'label' => Yii::t('app', 'Seguidores'),
                        'content' => $this->render('tabs/_followers.php', [
                            'followersSearch' => $followersSearch,
                            'followersProvider' => $followersProvider,
                        ]),
                    ]);

                    $items[] = Bootstrap::tabItem([
                        'icon' => 'fas fa-star',
                        'label' => Yii::t('app', 'Descripción'),
                        'content' => $this->render('tabs/_information.php', [
                            'model' => $model,
                        ]),
                    ]);
                    ?>
                    <?= TabsX::widget([
                        'id' => 'partner-view',
                        'items' => $items,
                        'position' => TabsX::POS_ABOVE,
                        'bordered' => true,
                        'encodeLabels' => false,
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <?= $this->render('_sidebar'); ?>
        </div>
    </div>
</div>