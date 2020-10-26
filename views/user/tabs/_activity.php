<?php

/* @var $this yii\web\View */

\yii\web\YiiAsset::register($this);

?>
<div class="user-activity">
    <?= $this->render('/reviews/index', [
        'searchModel' => $reviewsSearch,
        'dataProvider' => $reviewsProvider,
    ]); ?>
</div>