<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vats */

$this->title = Yii::t('app', 'Actualizar tipo de IVA: {label}', [
    'label' => $model->label,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipos de IVA'), 'url' => ['/admin/index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
?>
<div class="vats-update">

    <h1 class="display-4 my-5"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>