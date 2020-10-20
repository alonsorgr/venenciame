<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Denominations */

$this->title = Yii::t('app', 'Create Denominations');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Denominations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="denominations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
