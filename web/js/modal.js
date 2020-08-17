function show(selector, modal) {
    $(selector).click(function () {
        $(modal).modal('show')
            .find('#content')
            .load($(this).attr('value'));
    });
}

show('.show-modal-login', '#modal-login');