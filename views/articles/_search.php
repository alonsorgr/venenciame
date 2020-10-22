<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\ArticlesSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="articles-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'partner_id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'denomination_id') ?>

    <?= $form->field($model, 'vat_id') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'stock') ?>

    <?php // echo $form->field($model, 'degrees') ?>

    <?php // echo $form->field($model, 'capacity') ?>

    <?php // echo $form->field($model, 'variety') ?>

    <?php // echo $form->field($model, 'pairing') ?>

    <?php // echo $form->field($model, 'review') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
