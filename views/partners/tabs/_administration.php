<?php

/* @var $this yii\web\View */

use app\helpers\Bootstrap;
use app\models\User;
use kartik\tabs\TabsX;

\yii\web\YiiAsset::register($this);

?>

<div class="partners-administration pt-3">
    <div class="row mt-3">
        <div class="col-12">
            <?php
            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-home',
                'label' => Yii::t('app', 'General'),
                'content' => $this->render('administration/_main.php', [
                    'model' => $model
                ]),
            ]);

            $items[] = Bootstrap::tabItem([
                'icon' => 'fas fa-cart-arrow-down',
                'label' => Yii::t('app', 'Ventas'),
                'content' => $this->render('administration/_sales.php'),
            ]);
            ?>

            <?= TabsX::widget([
                'id' => 'partner-administration',
                'items' => $items,
                'position' => TabsX::POS_RIGHT,
                'bordered' => true,
                'encodeLabels' => false,
            ]); ?>
        </div>
    </div>
</div>