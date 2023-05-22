//Constante para completar la ruta de la API
const PRODUCTO_API = 'business/dashboard/products.php';
//Constante tipo objeto para obtener los parametros disponibles en la URL
const PARAMS = new URLSearchParams(location.search);
//Constantes para establecer el contenido principal de la pagina web
const TITULO = document.getElementById('title');
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
    RECORDS.textContent = '';
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
         
            <div class="col s10 m3">
              <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                   <img src="${SERVER_URL}images/products/${row.foto}" class="activator" >  
                </div>
                <div class="card-content">
                  <h3 class="card-title activator grey-text text-darken-4">${row.nombre_producto}</h3>
                    <div class="modal-footerD">
                    <span>Codigo: ${row.codigo_producto}</span>
                    <h5>$ ${row.precio_producto}</h5>
                    </div>
                    <div class ="card-action">
                        <button onclick="openUpdate(${row.id_producto})" class="btn blue tooltipped" data-tooltip="Actualizar">
                        <i class="material-icons">mode_edit</i>
                        </button>
                        <button onclick="openDelete(${row.id_producto})" class="btn red tooltipped" data-tooltip="Eliminar">
                                <i class="material-icons">delete</i>
                        </button>
                    </div>
                </div>
              </div>
            </div>
       
            `;
        });
        // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
        M.Tooltip.init(document.querySelectorAll('.tooltipped'));
        // Se muestra un mensaje de acuerdo con el resultado.
        RECORDS.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}