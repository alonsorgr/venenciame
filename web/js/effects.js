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

loading();

/**
 * Asigna una animación de entrada en una ventana modal.
 * @param string    anim    clase de la animación.
 */
function modalAnim(anim) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog  ' + anim + '  animated');
};

/**
 * Establece una animación de entrada en una ventana modal.
 * @param string    modal   id de la ventana modal.
 * @param string    event   evento de la ventana modal.
 * @param string    anim    animación de la ventana modal.
 */
function setModalAnim(modal, event, anim) {
    $(modal).on(event, function (e) {
        modalAnim(anim);
    });
}

setModalAnim('#modal-login', 'show.bs.modal', 'slideInLeft');
setModalAnim('#modal-register', 'show.bs.modal', 'slideInRight');

setModalAnim('#modal-login', 'hide.bs.modal', 'flipOutX');
setModalAnim('#modal-register', 'hide.bs.modal', 'flipOutX');