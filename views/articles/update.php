<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = Yii::t('app', 'Actualizar: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vinos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
?>
<div class="articles-update">
    <div class="row my-4 justify-content-between">
        <div class="col-xl-12">
            <div class="row display-5">
                <div class="col mb-4">
                    <?= Yii::t('app', 'Editar {title}', [
                        'title' => $model->title,
                    ]); ?>
                </div>
            </div>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>