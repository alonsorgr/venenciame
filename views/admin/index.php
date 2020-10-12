<?php


/* @var $this yii\web\View */
/* @var $userSearchModel app\models\search\UserSearch */
/* @var $userDataProvider yii\data\ActiveDataProvider */
/* @var $partnersSearchModel app\models\search\PartnersSearch */
/* @var $partnersDataProvider yii\data\ActiveDataProvider */

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
    </div>
</div>