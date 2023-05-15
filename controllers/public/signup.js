// Constante para establecer el formulario de registrar cliente.
const SIGNUP_FORM = document.getElementById('signup-form');
// Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
M.Tooltip.init(document.querySelectorAll('.tooltipped'));

// Evento para cuando se carga la página
document.addEventListener('DOMContentLoaded', () => {
    // LLamada a la función para asignar el token del reCAPTCHA al formulario.
    reCAPTCHA();
    // Evento para cargar cmb
    fillSelectType(USER_API, 'getAllGender', 'genero');
});

// Método manejador de eventos para cuando se envía el formulario de registrar cliente.
SIGNUP_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SIGNUP_FORM);
    // Petición para registrar un cliente.
    const JSON = await dataFetch(USER_API, 'signup', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'login.html');
    } else if (JSON.recaptcha) {
        sweetAlert(2, JSON.exception, false, 'index.html');
    } else {
        sweetAlert(2, JSON.exception, false);
        // Se genera un nuevo token cuando ocurre un problema.
        reCAPTCHA();
    }
});

/*
*   Función para obtener un token del reCAPTCHA y asignarlo al formulario.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
function reCAPTCHA() {
    // Método para generar el token del reCAPTCHA.
    grecaptcha.ready(() => {
        // Constante para guardar la llave pública del reCAPTCHA.
        const PUBLIC_KEY = '6LdBzLQUAAAAAJvH-aCUUJgliLOjLcmrHN06RFXT';
        // Se obtiene un token para la página web mediante la llave pública.
        grecaptcha.execute(PUBLIC_KEY, { action: 'homepage' }).then((token) => {
            // Se asigna el valor del token al campo oculto del formulario
            document.getElementById('g-recaptcha-response').value = token;
        });
    });
}