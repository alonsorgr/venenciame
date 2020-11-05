<?php

/* @var $this yii\web\View */
/* @var $model app\models\Partners */

use app\helpers\Bootstrap;

$icon = Yii::getAlias('@web/img/site/marker-icon-red.png');

?>
<div class="partners-location">
    <div class="row mt-4">
        <div class="col">
            <?= Bootstrap::header(Yii::t('app', 'Ubicación de la bodega {partner}', [
                'partner' => $model->name,
            ])); ?>
        </div>
    </div>
    <div id="map" class="map-box map mt-3" style="height: 600px;"></div>
</div>
<script>
    var map = L.map('map', {
        center: [36.776949, -6.350443],
        zoom: 16
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href=" https://www.openstreetmap.org/copyright">OpenStreetMap </a> contributors'
    }).addTo(map);

    var icon = new L.Icon({
        iconUrl: '<?= $icon ?>',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34]
    });

    var maker = L.marker([36.776949, -6.350443], {
        icon: icon,
    }).bindTooltip('<div><div class="d-inline font-weight-bold"><?= Yii::t('app', 'País') ?></div><div><?= $model->country->label ?></div>' +
        '<div><div class="d-inline font-weight-bold"><?= Yii::t('app', 'Provincia') ?></div><div><?= $model->state->label ?></div>' +
        '<div><div class="d-inline font-weight-bold"><?= Yii::t('app', 'Ciudad') ?></div><div><?= $model->city ?></div>' +
        '<div><div class="d-inline font-weight-bold"><?= Yii::t('app', 'Código Postal') ?></div><div><?= $model->zip_code ?></div>' +
        '<div><div class="d-inline font-weight-bold"><?= Yii::t('app', 'Dirección') ?></div><div><?= $model->address ?></div>', {
            permanent: false,
        });

    maker.addTo(map);

    $(document).ready(function() {
        setInterval(function() {
            map.invalidateSize(true);
        }, 100);
    });
</script>