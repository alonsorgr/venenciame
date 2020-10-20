<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Vats */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="vats-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'label')->textInput([
        'maxlength' => true,
        'placeholder' => Yii::t('app', 'Nombre del tipo de IVA'),
    ]) ?>

    <?= $form->field($model, 'value')->textInput([
        'maxlength' => true,
        'placeholder' => Yii::t('app', 'Valor del tipo de IVA'),
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>