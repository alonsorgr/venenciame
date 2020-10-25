<?php

use app\helpers\Bootstrap;
use app\models\Articles;
use app\models\User;
use kartik\tabs\TabsX;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vinos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="articles-view">
    <div class="row">
        <div class="col">
            <?= $this->render('_small', [
                'model' => $model,
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php
            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-info-circle',
                'label' => Yii::t('app', 'Ficha técnica'),
                'content' => $this->render('tabs/_data_sheet', [
                    'model' => $model,
                ]),
            ]);

            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-comments',
                'label' => Yii::t('app', 'Reseñas'),
                'content' => $this->render('tabs/_reviews'),
            ]);
            ?>
            <div class="mt-2">
                <?= TabsX::widget([
                    'id' => 'articles-view-container',
                    'items' => $items,
                    'position' => TabsX::POS_ABOVE,
                    'bordered' => true,
                    'encodeLabels' => false,
                ]); ?>
            </div>
        </div>
    </div>
    <?php if (User::isAdmin() || Articles::isOwner()) : ?>
        <div class="row">
            <div class="col mt-5">
                <?= Bootstrap::header(Yii::t('app', 'Administrar')); ?>
            </div>
        </div>
        <div class="row mb-3 justify-content-start mt-2">
            <div class="col-12 col-xl-3 mb-sm-3">
                <?= Html::a('<i class="fas fa-edit mr-2"></i>' . Yii::t('app', 'Editar artículo'), ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary btn-block']) ?>
            </div>
            <div class="col-12 col-xl-3">
                <?= Html::a('<i class="fas fa-trash mr-2"></i>' . Yii::t('app', 'Eliminar artículo'), Url::to(['articles/delete', 'id' => $model->id]), [
                    'class' => 'show-modal-delete-article btn btn-outline-danger btn-block',
                    'value' => Url::to(['articles/delete', 'id' => $model->id]),
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-delete-article',
                    'title' => Yii::t('app', 'Eliminar artículo')
                ]) ?>
            </div>
        </div>
    <?php endif ?>
</div>
<?php Bootstrap::modal([
    'id' => 'modal-delete-article',
    'image' => 'fas fa-trash',
    'size' => 'modal-lg',
    'title' => Yii::t('app', 'Eliminar artículo'),
]) ?>