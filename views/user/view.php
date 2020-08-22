<?php

use app\helpers\Bootstrap;
use kartik\tabs\TabsX;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="user-view">
    <div class="row justify-content-between">
        <div class="col-xl-8 mt-5">
            <div class="row">
                <div class="col-12 col-sm-auto">
                    <div class="mx-auto">
                        <div class="col d-flex justify-content-center align-items-center">
                            <div class="user-box">
                                <div class="image-profile">
                                    <?= Html::img(Html::encode($model->link), [
                                        'alt' => Yii::t('app', 'Imagen de usuario'),
                                        'data-action' => 'zoom',
                                        'title' => Yii::t('app', 'Imagen de usuario'),
                                    ]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col d-flex flex-column flex-sm-row justify-content-between">
                    <div class="text-center text-sm-left">
                        <div class="d-block mb-xl-2 lead">
                            <?= Html::encode($model->fullname) ?>
                        </div>
                        <div class="d-block">
                            <?= Html::encode($model->username) ?>
                        </div>
                        <div class="d-block">
                            <i class="fas fa-envelope mr-1"></i> 
                            <?= Yii::$app->formatter->asEmail(Html::encode($model->email)) ?>
                        </div>
                    </div>
                    <div class="text-center text-sm-right">
                        <small class="text-muted">
                            <i class="fas fa-calendar icon-sm mr-1"></i>
                            <?= Yii::t('app', 'Registrado el {date}', [
                                'date' => Html::encode(Yii::$app->formatter->asDate($model->created_at)),
                            ]) ?>
                        </small>
                    </div>
                </div>
            </div>
            <div class="mt-xl-1 horizontal-divider"></div>

            <?php
            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-chart-line',
                'label' => Yii::t('app', 'Actividad'),
                'content' => $this->render('tabs/_activity.php'),
            ]);

            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-heart',
                'label' => Yii::t('app', 'Seguidos'),
                'content' => $this->render('tabs/_followed.php'),
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