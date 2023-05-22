//Constante para completar la ruta de la API
const PRODUCTO_API = 'business/dashboard/products.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
//Constantes para establecer el contenido principal de la pagina web
const PRODUCTOS = document.getElementById('productos');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    cargarProductos();
});

// Método manejador de eventos para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    cargarProductos(FORM);
});

async function cargarProductos(form = null) {
    // Se inicializa el contenido de la tabla.
    PRODUCTOS.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRODUCTO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            PRODUCTOS.innerHTML += `
            <div class="col s12 m3">
                <div class="card">
                    <div class="card-image">
                      <img src="${SERVER_URL}images/products/${row.foto}" class="materialboxed">
                    </div>
                    <div class="card-content">
                        <span class="card-title">${row.nombre_producto}</span>
                        <span>${row.descripcion_producto}</span>
                        <h5>$ ${row.precio_producto}</h5>
                    </div>
                    <div class="card-action">
                      <a href="#">This is a link</a>
                    </div>
                  </div>
            </div>
       
            `;
        });
        // Se inicializa el componente materialbox
        M.Materialbox.init(document.querySelectorAll('.materialboxed'));
        // Se inicializa el componente tooltipped
        M.Tooltip.init(document.querySelectorAll('.tooltipped'));
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}