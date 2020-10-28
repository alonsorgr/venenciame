<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CartItems */

$this->title = Yii::t('app', 'Create Cart Items');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cart Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
