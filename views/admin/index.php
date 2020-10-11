<?php


/* @var $this yii\web\View */
/* @var $userSearchModel app\models\search\UserSearch */
/* @var $userDataProvider yii\data\ActiveDataProvider */

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