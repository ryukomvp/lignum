// Constante para establecer el formulario de registro del primer usuario.
const SIGNUP_FORM = document.getElementById('signup-form');
// Constante para establecer el formulario de inicio de sesión.
const LOGIN_FORM = document.getElementById('login-form');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para consultar los usuarios registrados.
    const JSON = await dataFetch(USER_API, 'readUsers');
    // Se comprueba si existe una sesión, de lo contrario se sigue con el flujo normal.
    if (JSON.session) {
        // Se direcciona a la página web de bienvenida.
        location.href = 'main.html';
    } else if (JSON.status) {
        // Se muestra el formulario para iniciar sesión.
        document.getElementById('login-container').classList.remove('hide');
        sweetAlert(4, JSON.message, true);
    } else {
        // Se muestra el formulario para registrar el primer usuario.
        document.getElementById('signup-container').classList.remove('hide');
        sweetAlert(4, JSON.exception, true);
    }
});