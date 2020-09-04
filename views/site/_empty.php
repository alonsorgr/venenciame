<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

\yii\web\YiiAsset::register($this);

$title = Yii::t('app', 'No se encontraron resultados');

?>
<div class="site-empty mt-5" id="site-empty">
    <div class="container text-center">
        <?=
            Html::img('@web/img/site/empty.svg', [
                'class' => 'empty-results mb-3',
                'alt' => $title,
                'title' => $title,
            ])
        ?>
        <?= Html::tag('h2', $title, [
            'class' => 'lead',
            'title' => $title,
        ]) ?>
    </div>
</div>