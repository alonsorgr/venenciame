<?php

use app\models\User;
use kartik\tabs\TabsX;
use app\helpers\Bootstrap;

/* @var $this yii\web\View */
/* @var $model app\models\Partners */
/* @var $followersSearch app\models\UserSearch */
/* @var $followersProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bodegas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="partners-view">
    <div class="row justify-content-between">
        <div class="col-xl-12">
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
                        'icon' => 'fas fa-info-circle',
                        'label' => Yii::t('app', 'Descripción'),
                        'content' => $this->render('tabs/_information.php', [
                            'model' => $model,
                        ]),
                    ]);
                    
                    if ($model->isOwner() || User::isAdmin()) {
                        $items[] = Bootstrap::tabItem([
                            'icon' => 'fas fa-cogs',
                            'label' => Yii::t('app', 'Administrar'),
                            'content' => $this->render('tabs/_administration.php', [
                                'model' => $model,
                            ]),
                        ]);
                    }

                    ?>
                    <?= TabsX::widget([
                        'id' => $model->isOwner() ? 'partner-view-container' : 'partner-view-container-0',
                        'items' => $items,
                        'position' => TabsX::POS_ABOVE,
                        'bordered' => true,
                        'encodeLabels' => false,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>