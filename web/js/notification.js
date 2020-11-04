/**
 * Muestra una notificación en la barra de navegación.
 * @param string id         id del elemento.
 * @param string text       texto a mostrar.
 * @param string type       tipo de notificación.
 * @param string position   posición de la notificación.
 * @param string style      estilo de la notificación.
 */
function notification(id, text, type, position = 'bottom left', style = 'bootstrap') {
    $(id).notify(text, {
        style: style,
        className: type,
        position: position,
    });
}