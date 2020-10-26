<?php

/* @var $this yii\web\View */

\yii\web\YiiAsset::register($this);

?>
<?php if (!Yii::$app->user->isGuest) : ?>
    <div class="user-activity">
        <?= $this->render('/reviews/index', [
            'searchModel' => $reviewsSearch,
            'dataProvider' => $reviewsProvider,
        ]); ?>
    </div>
    <?php else : ?>
    <div class="user-activity">
        <div class="lead text-center  text-xl-left mt-5">
            <?= Yii::t('app', 'Debe estar registrado para ver la actividad del usuario.'); ?>
        </div>
    </div>
<?php endif ?>