function show(selector, modal) {
    $(selector).click(function () {
        $(modal).modal('show')
            .find('#content')
            .load($(this).attr('value'));
    });
}

show('.show-modal-login', '#modal-login');
show('.show-modal-logout', '#modal-logout');
show('.show-modal-register', '#modal-register');