/**
 * Carga una petición al controlador para la carga por AJAX de la vista.
 * @param {string} selector     selector que dispara el evento.
 * @param {string} modal        referencia a la ventana modal.
 */
function show(selector, modal)
{
    $(selector).click(function () {
        $(modal).modal('show')
            .find('#content' + modal.substring(1))
            .load($(this).attr('value'));
    });
}

show('.show-modal-login', '#modal-login');
show('.show-modal-logout', '#modal-logout');
show('.show-modal-register', '#modal-register');
show('.show-modal-delete-article', '#modal-delete-article');
show('.show-modal-reviews-article', '#modal-reviews-article');