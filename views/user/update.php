<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Update User: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Editar');
?>
<div class="user-update">
    <div class="row my-4 justify-content-between">
        <div class="col-xl-8">
            <div class="row display-5">
                <div class="col mb-4">
                    <?= Yii::t('app', 'Editar perfil'); ?>
                </div>
            </div>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
        <div class="col-xl-3">
            <?= $this->render('_sidebar'); ?>
        </div>
    </div>
</div>