<?php

/* @var $this yii\web\View */
/* @var $model app\models\Partners */

use yii\bootstrap4\Html;

\yii\web\YiiAsset::register($this);

?>

<div class="partners-information">
    <div class="lead-sm text-center m-5">
        <?= Html::encode($model->information) ?>
    </div>
</div>