<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\VatsSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="vats-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-12 col-md-10">
            <?= $form->field($model, 'label')->textInput([
                'maxlength' => true,
                'placeholder' => Yii::t('app', 'Buscar por etiqueta de tipo de IVA'),
                'title' => Yii::t('app', 'Etiqueta de tipo de IVA'),
            ]); ?>
        </div>
        <div class="col-12 col-md-2 my-4">
            <?= Html::submitButton('<i class="fas fa-search mr-2"></i>' . Yii::t('app', 'Buscar'), [
                'class' => 'btn btn-outline-primary btn-block',
                'placeholder' => Yii::t('app', 'Buscar'),
                'title' => Yii::t('app', 'Buscar'),
            ]); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>