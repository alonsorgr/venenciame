<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vats */

$this->title = Yii::t('app', 'Agregar un tipo de IVA');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipos de IVA'), 'url' => ['/admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vats-create">

    <h1 class="display-4 my-5"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>