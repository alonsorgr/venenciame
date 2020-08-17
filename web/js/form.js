/**
 * Función de revelado de contraseña en input.
 * 
 * @param {*} $input    selector id para el elemento input.
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