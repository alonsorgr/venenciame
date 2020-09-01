<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Followers */

$this->title = Yii::t('app', 'Create Followers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Followers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="followers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
