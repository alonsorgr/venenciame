<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\bootstrap4\Html;

$this->title = Yii::t('app', 'Acerca de');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <div class="row my-4 justify-content-between">
        <div class="col-xl-8">
            <div class="row display-4">
                <?= Yii::t('app', 'Acerca de {appname}', [
                    'appname' => Yii::$app->name,
                ]); ?>
            </div>
            <div class="row mt-4">
                <?= Html::tag('p', Yii::t('app', '{title}' . ' se presenta no sólo como una tienda on-line distribuidora de vinos focalizada en productos del marco de Jerez, si no como una forma de acercar nuestra vinicultura a todo el mundo, ya que se trata de una aplicación web que dispone de diferentes secciones, para que además de poner al alcance el producto al cliente, éstos puedan acceder a su descripción y a los perfiles de cada bodega que lo elaboran para así conocer mejor de donde viene el producto.', [
                    'title' => Html::encode(Yii::$app->name),
                ]), [
                    'class' => 'lead'
                ]) ?>
            </div>
            <div class="row mt-4">
                <?= Html::tag('p', Yii::t('app', 'La idea parte de la necesidad de promocionar nuestra cultura vitivinícola, acercar a la gente a nuestra tierra, y hacer que los que ya la habiten, la conozcan mejor, todo esto con la finalidad de aumentar el turismo en esta zona relacionado este sector y el volumen de consumo de vinos de Jerez, para así poder lograr un incremento en las ventas de este producto, y, por lo tanto, ampliar las posibilidades económicas dentro de este ámbito. '), [
                    'class' => 'lead'
                ]) ?>
            </div>
            <div class="row mt-4">
                <?= Html::tag('p', Yii::t('app', 'Somos una distribuidora de bebidas alcohólicas y vinagre, a través de un servicio web, en el que se podrán hacer pedidos on-line para comprar los artículos. Los pedidos podrán realizarse por botellas individuales o por cajas de 6 y 12 unidades. Algunos artículos vienen en formato estuche de 3 botellas, estos también serán contemplados.'), [
                    'class' => 'lead'
                ]) ?>
            </div>
            <div class="mt-4 d-flex justify-content-end">
                <?= Html::tag('p', Yii::t('app', '«El vino lava nuestras inquietudes, enjuaga el alma hasta el fondo y asegura la curación de la tristeza.»'), [
                    'class' => 'blockquote-footer blockquote-text-size text-site'
                ]) ?>
            </div>
        </div>
        <div class="col-xl-3">
            <?= $this->render('_aside'); ?>
        </div>
    </div>
</div>