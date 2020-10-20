<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Denominations */

$this->title = Yii::t('app', 'Agregar una denominación de origen');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Denominaciones de origen'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="denominations-create">

    <h1 class="display-4 my-5"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>