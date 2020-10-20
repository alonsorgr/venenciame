<?php


/* @var $this yii\web\View */
/* @var $userSearchModel app\models\search\UserSearch */
/* @var $userDataProvider yii\data\ActiveDataProvider */
/* @var $partnersSearchModel app\models\search\PartnersSearch */
/* @var $partnersDataProvider yii\data\ActiveDataProvider */
/* @var $categoriesSearchModel app\models\search\CategoriessSearch */
/* @var $categoriesDataProvider yii\data\ActiveDataProvider */
/* @var $denominationsSearchModel app\models\search\DenominationssSearch */
/* @var $denominationsDataProvider yii\data\ActiveDataProvider */
/* @var $vatsSearchModel app\models\search\VatsSearch */
/* @var $vatssDataProvider yii\data\ActiveDataProvider */

use app\helpers\Bootstrap;
use kartik\tabs\TabsX;

$this->title = Yii::t('app', 'Administración');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">
    <div class="row justify-content-between">
        <div class="col-xl-12">
            <?php
            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-user',
                'label' => Yii::t('app', 'Usuarios'),
                'content' => $this->render('tabs/_user', [
                    'userSearchModel' => $userSearchModel,
                    'userDataProvider' => $userDataProvider,
                ]),
            ]);
            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-handshake',
                'label' => Yii::t('app', 'Socios'),
                'content' => $this->render('tabs/_partners', [
                    'partnersSearchModel' => $partnersSearchModel,
                    'partnersDataProvider' => $partnersDataProvider,
                ]),
            ]);
            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-list-ul',
                'label' => Yii::t('app', 'Categorías'),
                'content' => $this->render('tabs/_categories', [
                    'categoriesSearchModel' => $categoriesSearchModel,
                    'categoriesDataProvider' => $categoriesDataProvider,
                ]),
            ]);
            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-seedling',
                'label' => Yii::t('app', 'Denominaciones'),
                'content' => $this->render('tabs/_denominations', [
                    'denominationsSearchModel' => $denominationsSearchModel,
                    'denominationsDataProvider' => $denominationsDataProvider,
                ]),
            ]);
            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-money-bill',
                'label' => Yii::t('app', 'Tipos de IVA'),
                'content' => $this->render('tabs/_vats', [
                    'vatsSearchModel' => $vatsSearchModel,
                    'vatsDataProvider' => $vatsDataProvider,
                ]),
            ]);
            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-wine-glass',
                'label' => Yii::t('app', 'Artículos'),
                'content' => $this->render('tabs/_articles'),
            ]);
            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-truck',
                'label' => Yii::t('app', 'Pedidos'),
                'content' => $this->render('tabs/_orders'),
            ]);
            ?>
            <div class="mt-5">
                <?= TabsX::widget([
                    'id' => 'admin-index-container',
                    'items' => $items,
                    'position' => TabsX::POS_ABOVE,
                    'bordered' => true,
                    'encodeLabels' => false,
                ]); ?>
            </div>
        </div>
    </div>
</div>