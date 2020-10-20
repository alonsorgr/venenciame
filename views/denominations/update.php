<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Denominations */

$this->title = Yii::t('app', 'Actualizar denominación de origen: {label}', [
    'label' => $model->label,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Denominaciones de origen'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->label, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
?>
<div class="denominations-update">

    <h1 class="display-4 my-5"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>