<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Denominations */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="denominations-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'label')->textInput([
        'maxlength' => true,
        'placeholder' => Yii::t('app', 'Nombre de la denominación de origen'),
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>