<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vats */

$this->title = Yii::t('app', 'Create Vats');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vats-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
