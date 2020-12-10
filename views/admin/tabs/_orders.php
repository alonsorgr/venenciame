<?php

/* @var $this yii\web\View */
/* @var $partnersSearchModel app\models\search\PartnersSearch */
/* @var $partnersDataProvider yii\data\ActiveDataProvider */

use yii\widgets\Pjax;
use yii\bootstrap4\Html;
use yii\widgets\ListView;
use app\helpers\Bootstrap;

\yii\web\YiiAsset::register($this);

?>

<div class="admin-articles">

    <?php Pjax::begin([
        'id' => 'admin-articles-pjax',
        'timeout' => '100000',
    ]); ?>
    <div class="row mt-5">
        <div class="col">
            <?= $this->render('/orders/_search_admin', [
                'model' => $ordersSearch,
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>