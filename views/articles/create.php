<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = Yii::t('app', 'Agregar un nuévo artículo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vinos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-create">
    <div class="row my-4 justify-content-between">
        <div class="col-xl-12">
            <div class="row display-5">
                <div class="col mb-4">
                    <?= Yii::t('app', 'Crear un nuevo artículo de vino'); ?>
                </div>
            </div>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>