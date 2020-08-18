<?php

/* @var $this yii\web\View */

use app\helpers\Bootstrap;

\yii\web\YiiAsset::register($this);

?>
<div class="site-privacity mt-5" id="site-privacity">
    <div class="container modal-scroll">
        <p>La visita a este sitio Web no implica que el usuario esté obligado a facilitar ninguna información. En el caso de que el usuario facilite alguna información de carácter personal, los datos recogidos en este sitio web serán tratados de forma leal y lícita con sujeción en todo momento a los principios y derechos recogidos en el Reglamento (UE) 2016/679, de 27 de abril, General de Protección de Datos (RGPD) y demás normativa aplicable.</p>
        <p>En cumplimiento de lo dispuesto en el artículo 13 del RGPD te informamos de lo siguiente:</p>
        <?= Bootstrap::header('Responsable') ?>
        <p>VENÉNCIEME S.A</p>
        <p>Avda. Andalucía, Parcelas 2-5 y 2-6 Polígono Industrial Las Coquinas, 11540 Sanlúcar de Barrameda</p>
        <p>eléfono de contacto: 999-666-999</p>
        <?= Bootstrap::header('Delegado de protección de datos') ?>
        <p>Hemos designado un delegado de protección de datos (DPO) para cualquier cuestión relacionada con sus datos personales. Puede contactar con él a través de la dirección soporte.venenciame.gmail.com</p>
        <?= Bootstrap::header('Calidad de los datos') ?>
        <p>Los usuarios deberán garantizar la veracidad, exactitud, autenticidad y vigencia de los datos de carácter personal que les hayan sido recogidos.</p>
        <?= Bootstrap::header('Protección de los menores') ?>
        <p>No recogemos datos personales de menores. Es responsabilidad del padre/madre/tutor legal velar por para la privacidad de los menores, haciendo todo lo posible para asegurar que han autorizado la recogida y el uso de los datos personales del menor.</p>
    </div>
</div>