/**
 * Función de animación de carga de datos.
 */
function loading() {
    function loader() {
        $('.page-loader-wrapper').fadeOut();
    }
    $(document).on("pjax:beforeSend", function (e) {
        $('.page-loader-wrapper').fadeIn();
    }).on("pjax:end", function () {
        loader();
    });
    loader();
}