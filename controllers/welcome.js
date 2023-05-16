/*
*   Controlador de uso general en las páginas web del sitio privado.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const BIENVENIDA = document.getElementById('bienvenida');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USER_API, 'getUser');
    console.log(USER_API);
    BIENVENIDA.innerHTML = `
        <h1 class="center-align">Bienvenido <b>${JSON.username}</b></h1>
    `;
});