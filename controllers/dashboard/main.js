//Constante para completar la ruta de la API
const PRODUCTO_API = 'business/dashboard/products.php';

document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USER_API, 'getUser');
    console.log(USER_API);
    BIENVENIDA.innerHTML = `
        <h1 class="center-align">Bienvenido <b>${JSON.username}</b></h1>
    `;
});