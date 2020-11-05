<?php

/* @var $this yii\web\View */
/* @var $model app\models\Partners */

use app\helpers\Bootstrap;

$icon = Yii::getAlias('@web/img/site/marker-icon.png');

?>
<?php if ($model->latitude !== '' && $model->longitude !== '') : ?>
    <div class="partners-location">
        <div class="row mt-5">
            <div class="col">
                <?= Bootstrap::header(Yii::t('app', 'Ubicación de la bodega {partner}', [
                    'partner' => $model->name,
                ])); ?>
            </div>
        </div>
        <div id="map" class="map-box map mt-1"></div>
    </div>
    <script>
        var map = L.map('map', {
            center: ['<?= $model->latitude ?>', '<?= $model->longitude ?>'],
            zoom: 8
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

        var maker = L.marker(['<?= $model->latitude ?>', '<?= $model->longitude ?>'], {
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

<?php else : ?>
    <div class="row mt-4">
        <div class="col">
            <?= $this->render('/site/_empty'); ?>
        </div>
    </div>
<?php endif ?>