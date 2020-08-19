<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <div class="row my-4 justify-content-between">
        <div class="col-xl-8">
            <div class="row display-5">
                <div class="col mb-4">
                    <?= Yii::t('app', 'Crear usuario'); ?>
                </div>
            </div>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
        <div class="col-xl-3">
            <?= $this->render('/site/_aside'); ?>
        </div>
    </div>
</div>