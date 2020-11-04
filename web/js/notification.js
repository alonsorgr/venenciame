/**
 * Muestra una notificación en la barra de navegación.
 * @param string id         id del elemento.
 * @param string text       texto a mostrar.
 * @param string type       tipo de notificación.
 * @param string position   posición de la notificación.
 * @param string style      estilo de la notificación.
 */
function notification(id, text, type, position = 'bottom left', style = 'app') {
    $.notify.addStyle('app', {
        html: "<div style='z-index: 99999'><i class='fas fa-check-circle mr-2' style='color: #797979'></i><span data-notify-text/></div>",
        classes: {
            base: {
                "white-space": "nowrap",
                "background-color": "#F2F2F2",
                "border-radius": "4px",
                "padding": "10px",
                "border": "1px solid #d9d9d9",
            },
        }
    });
    $(id).notify(text, {
        style: style,
        className: type,
        position: position,
    });
}