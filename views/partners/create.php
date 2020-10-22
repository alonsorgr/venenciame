<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Partners */

$this->title = Yii::t('app', 'Dar de alta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bodegas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partners-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>