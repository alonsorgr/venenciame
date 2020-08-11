<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;

?>
<div class="site-error mt-5" id="site-error">
    <div class="container text-center">
        <div class="error-container mb-4">
            <?= Html::img('@web/img/site/glass.svg', [
                'class' => 'error-anim',
                'title' => Yii::t('app', 'Imagen animada de copa de vino'),
                'atl' => Yii::t('app', 'Imagen animada de copa de vino'),
            ]) ?>
        </div>

        <?= Html::tag('h1', Html::encode($this->title), [
            'class' => 'display-4',
            'title' => Yii::t('app', 'Mensaje de error'),
        ]) ?>

        <?= Html::tag('p', nl2br(Html::encode($message)), [
            'class' => 'lead',
            'title' => Yii::t('app', 'Descripción del error'),
        ]) ?>

        <?= Html::a(Yii::t('app', 'Ir a la página principal'), ['site/index'], [
            'class' => 'btn btn-primary',
            'title' => Yii::t('app', 'Ir a la página principal'),
        ]) ?>

    </div>
</div>