/**
 * Función de revelado de contraseña en input.
 * @param {sitring} $input    selector id para el elemento input.
 */
function passwordInput(input) {
    $($('#password-input-icon').on('click', function (event) {
        event.preventDefault();
        if ($('#'.concat(input)).attr("type") == "text") {
            $('#'.concat(input)).attr('type', 'password');
            $('#password-input-icon').addClass("fa-eye-slash text-primary");
            $('#password-input-icon').removeClass("fa-eye");
        } else if ($('#'.concat(input)).attr("type") == "password") {
            $('#'.concat(input)).attr('type', 'text');
            $('#password-input-icon').removeClass("fa-eye-slash text-primary");
            $('#password-input-icon').addClass("fa-eye");
        }
    }));
}

function submitAjax(form, url) {
    $('#'.concat(form)).on('beforeSubmit', function (e) {
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (data) {
                console.log(data);
            },
        });
    }).on('submit', function (e) {
        e.preventDefault();
    });
}