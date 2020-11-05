/**
 * Constante de iconos
 */
const iconos = [
    window.location.protocol + "//" + window.location.host + "/img/marker-icon-blue.png",
    window.location.protocol + "//" + window.location.host + "/img/marker-icon-red.png",
];

/**
 * Constantes de colores
 */
const colores = ['red', 'green', 'blue', 'orange', 'black', 'yellow', 'violet'];

/**
 * Altitud de ubicación
 */
var altitud = [];

/**
 * Fecha de la toma de la ubicación
 */
var fecha = [];

/**
 * Satelite que devuelve los datos de la ubicación
 */
var satelite = [];

/**
 * Velocidad de movimiento de GPS
 */
var velocidad = [];

/**
 * Array de todos los datos de la ubicación
 */
var arrayDatos = [];

/**
 * Atributo de instancia del mapa
 */
var map;

/**
 * Array de marcadores
 */
var marcadores = [];

/**
 * Capas del mapa
 */
var capas;

/**
 * Líneas del mapa
 */
var lineas;
/**
 * Rutas del GPS
 */
var ruta = [];

/**
 * Nivel de batería
 */
var level = [];

/**
 * Actualiza los datos del mapa
 */
function actualizar() {
    if (arrayDatos.length === 0) {
        return;
    }

    if (ruta.length != 0) {
        ruta = [];
    }

    if (fecha.length != 0) {
        fecha = [];
    }

    if (level.length != 0) {
        level = [];
    }

    agregarRutas();
    agregarAltitudes();
    agregarFechas();
    agregarSatelites();
    agregarVelocidad();
    agregarLevel();
    resetearMarcadores(marcadores);

    var grupoCapas;

    if (marcadores.length != 0) {
        marcadores = [];
    }

    for (let i = 0; i < ruta.length; i++) {

        let ic = '';

        if (i == 0) {
            ic = iconos[0];
        } else if (i == ruta.length - 1) {
            ic = iconos[1];
        }

        var icono = new L.Icon({
            iconUrl: ic,
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34]
        });

        var empty = new L.Icon({
            iconUrl: window.location.protocol + "//" + window.location.host + "/img/empty.png",
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34]
        });

        var pos = i == 0 ? '<b>Inicio del trayecto</b><br><br>' : pos = i == ruta.length - 1 ? '<b>Fin del trayecto</b><br><br>' : '';

        if (i == 0 || i == ruta.length - 1) {

            var marcador = L.marker(ruta[i], {
                icon: icono,
            }).bindTooltip(pos.concat('<b>Latitud:</b> '.concat(ruta[i][0]))
                .concat('<br><b>Longitud:</b> '.concat(ruta[i][1]))
                .concat('<br><b>Altitud:</b> '.concat(altitud[i] + ' m'))
                .concat('<br><b>Fecha:</b> '.concat(fecha[i]))
                .concat('<br><b>Satélite:</b> '.concat(satelite[i]))
                .concat('<br><b>Velocidad:</b> '.concat(velocidad[i] + ' km/h'))
                .concat('<br><b>Batería:</b> '.concat(parseFloat(level[i]) + ' %')), {
                    permanent: false,
                    direction: 'right',
                }).on('click', function () {
                sidebar.setContent(
                    '<div class="site-test col-12" style="margin-top: 50px;">' +
                    '<ul class="list-group list-group-flush bg-light">' +
                    '<div class="container">' +
                    '<div class="text-left text-primary pb-3 col-12" style="font-size: 1.2em; margin-left: -25px; margin-top: -25px;">Información detallada del marcador</div>' +
                    '</div>' +
                    '<li class="list-group-item mt-5 bg-light">' +
                    '<div class="row justify-content-between bg-light">' +
                    '<div class="mt-2 text-dark">Latitud:</div>' +
                    '<div class="badge badge-pill badge-light">' +
                    '<div style="margin-top: 10px; font-size: 1.1em;">' + ruta[i][0] + '</div>' +
                    '</div>' +
                    '</div>' +
                    '</li>' +
                    '<li class="list-group-item bg-light">' +
                    '<div class="row justify-content-between bg-light">' +
                    '<div class="mt-2 text-dark">Longitud:</div>' +
                    '<div class="badge badge-pill badge-light">' +
                    '<div style="margin-top: 10px; font-size: 1.1em;">' + ruta[i][1] + '</div>' +
                    '</div>' +
                    '</div>' +
                    '</li>' +
                    '<li class="list-group-item bg-light">' +
                    '<div class="row justify-content-between bg-light">' +
                    '<div class="mt-2 text-dark">Altitud:</div>' +
                    '<div class="badge badge-pill badge-light">' +
                    '<div style="margin-top: 10px; font-size: 1.1em;">' + altitud[i] + ' m' + '</div>' +
                    '</div>' +
                    '</div>' +
                    '</li>' +
                    '<li class="list-group-item bg-light">' +
                    '<div class="row justify-content-between bg-light">' +
                    '<div class="mt-2 text-dark">Fecha y hora:</div>' +
                    '<div class="badge badge-pill badge-light">' +
                    '<div style="margin-top: 10px; font-size: 1.1em;">' + fecha[i] + '</div>' +
                    '</div>' +
                    '</div>' +
                    '</li>' +
                    '<li class="list-group-item bg-light">' +
                    '<div class="row justify-content-between bg-light">' +
                    '<div class="mt-2 text-dark">Velocidad:</div>' +
                    '<div class="badge badge-pill badge-light">' +
                    '<div style="margin-top: 10px; font-size: 1.1em;">' + velocidad[i] + ' km/h' + '</div>' +
                    '</div>' +
                    '</div>' +
                    '</li>' +
                    '<li class="list-group-item bg-light">' +
                    '<div class="row justify-content-between bg-light">' +
                    '<div class="mt-2 text-dark">Nivel de batería:</div>' +
                    '<div class="badge badge-pill badge-light">' +
                    '<div style="margin-top: 10px; font-size: 1.1em;">' + parseFloat(level[i]) + ' %' + '</div>' +
                    '</div>' +
                    '</div>' +
                    '</li>' +
                    '</ul>' +
                    '</div>'
                );
                sidebar.toggle();
            });
        }
        marcadores.push(marcador);
        marcadores[i].addTo(map);
    }

    if (lineas) {
        for (linea of lineas) {
            map.removeLayer(linea)
            lineas = crearRuta(ruta, map);
        }
    } else {
        lineas = crearRuta(ruta, map);
    }

    if (lineas.length == 0) {
        lineas = [];
    }

    if (grupoCapas) {
        grupoCapas.clearLayers();
    } else {
        grupoCapas = new L.LayerGroup();
    }

    for (linea of lineas) {
        grupoCapas.addLayer(linea);
    }

    grupoCapas.addTo(map);

    if (capas) {
        map.eachLayer(function (layer) {
            if (layer instanceof L.Polyline) {
                capas.removeLayer(layer);
            }
        });
    } else {
        capas = new L.FeatureGroup();
    }

    map.eachLayer(function (layer) {
        if (layer instanceof L.Polyline) {
            capas.addLayer(layer);
        }
    });

    if (capas.getLayers().length != 0) {
        map.fitBounds(capas.getBounds(), {
            maxZoom: 17
        });
    }
}


if (map) {
    map.off();
    map.remove();
} else {
    map = creaMapa();
}

creaSideBar(map);

/**
 * Obtiene los datos de una consulta a la base de datos
 * 
 * @param Array datos   datos de la consulta
 */
function obtenerDatos(datos) {
    arrayDatos = datos;
}

/**
 * Agrega las rutas desde el array de datos
 */
function agregarRutas() {
    for (let i = 0; i < arrayDatos.length; i++) {
        let arr = [];
        arr.push(arrayDatos[i][1]);
        arr.push(arrayDatos[i][2]);
        ruta.push(arr);
    }
}

/**
 * Agrega altitudes desde el array de datos
 */
function agregarAltitudes() {
    for (let i = 0; i < arrayDatos.length; i++) {
        let arr = [];
        arr.push(arrayDatos[i][6]);
        altitud.push(arr);
    }
}

/**
 * Convierte fecha y hora UTC a hora local del cliente
 * 
 * @param Date date     fecha a formatear
 */
function UTCToLocalTimeString(date) {
    options = {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour24: true,
        timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone,
    };
    timeOffsetInHours = (new Date().getTimezoneOffset() / 60) * (-1);
    date.setHours(date.getHours() + timeOffsetInHours);
    date = new Intl.DateTimeFormat('default', options).format(date);
    return date;
}

/**
 * Agrega fechas desde el array de datos
 */
function agregarFechas() {
    for (let i = 0; i < arrayDatos.length; i++) {
        let arr = [];
        let year = arrayDatos[i][3].toString().substring(0, 4);
        let mes = arrayDatos[i][3].toString().substring(4, 6);
        let dia = arrayDatos[i][3].toString().substring(6, 8);
        let hora = arrayDatos[i][3].toString().substring(8, 10);
        let minuto = arrayDatos[i][3].toString().substring(10, 12);
        let segundo = arrayDatos[i][3].toString().substring(12, 14);
        date = new Date(year + '-' + mes + '-' + dia + ' ' + hora + ':' + minuto + ':' + segundo);
        arr.push(UTCToLocalTimeString(date));
        fecha.push(arr);
    }
}

/**
 * Agrega los satelites desde el array de datos
 */
function agregarSatelites() {
    for (let i = 0; i < arrayDatos.length; i++) {
        let arr = [];
        arr.push(arrayDatos[i][4]);
        satelite.push(arr);
    }
}

/**
 * Agrega la velocidad desde el array de datos
 */
function agregarVelocidad() {
    for (let i = 0; i < arrayDatos.length; i++) {
        let arr = [];
        arr.push(arrayDatos[i][5]);
        velocidad.push(arr);
    }
}

function agregarLevel() {
    for (let i = 0; i < arrayDatos.length; i++) {
        let arr = [];
        arr.push(arrayDatos[i][8]);
        level.push(arr);
    }
}

/**
 * Crea el mapa en la vista
 */
function creaMapa() {
    var map = L.map('mapa', {
        center: [36.776949, -6.350443],
        zoom: 14
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    return map;
}

/**
 * Resetera los marcadores del mapa
 * 
 * @param array marcadores  marcadores a resetear
 */
function resetearMarcadores(marcadores) {
    if (marcadores.length != 0) {
        for (marcador of marcadores) {
            marcador.remove();
            30000
        }
        marcadores = [];
    }
}

/**
 * Dibuja la ruta en el mapa
 * 
 * @param Array ruta array de rutas
 */
function crearRuta(ruta) {
    polyline = L.polyline(ruta, {
        weight: 3,
        color: '#2c3e50'
    }).bindPopup('Recorrido');
    arrowHead = L.polylineDecorator(polyline, {
        patterns: [{
            offset: '1%',
            repeat: 200,
            symbol: L.Symbol.arrowHead({
                pixelSize: 15,
                polygon: true,
                pathOptions: {
                    stroke: true,
                    color: '#2c3e50'
                }
            })
        }]
    });
    return [polyline, arrowHead];
}

/**
 * Crea el menú lateral de los datos
 * 
 * @param Object map mapa
 */
function creaSideBar(map) {
    sidebar = L.control.sidebar('sidebar', {
        closeButton: true,
        position: 'left',
    });

    sidebar.on('click', function () {
        sidebarLocal.toggle();
    });

    map.addControl(sidebar);
}


map.on('click', function () {
    sidebar.hide();
});