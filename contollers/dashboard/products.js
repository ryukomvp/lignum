// Constantes para completar las rutas de la API.
const PRODUCTO_API = 'business/dashboard/producto.php';
const CATEGORIA_API = 'business/dashboard/categoria.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para establecer el contenido de la carta
const CBODY_ROWS = document.getElementById('cbody-row');
const RECORDS = document.getElementById('records');
// Constante tipo objeto para establecer las opciones del componente Modal.
const OPTIONS = {
    dismissible: false
}
// Inicialización del componente Modal para que funcionen las cajas de diálogo.
M.Modal.init(document.querySelectorAll('.modal'), OPTIONS);
// Constante para establecer la modal de guardar.
const SAVE_MODAL = M.Modal.getInstance(document.getElementById('save-modal'));

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la carta con los registros disponibles.
    fillCard();
});

// Método manejador de eventos para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la carta con los resultados de la búsqueda.
    fillCard(FORM);
});

// Método manejador de eventos para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(PRODUCTO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la carta para visualizar los cambios.
        fillCard();
        // Se cierra la caja de diálogo.
        SAVE_MODAL.close();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

/*
*   Función asíncrona para llenar la carta con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
async function fillCard(form = null) {
    // Se inicializa el contenido de la tabla.
    CBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRODUCTO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
      // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
      JSON.dataset.forEach(row => {
          // Se establece un icono para el estado del producto.
          (row.estado_producto) ? icon = 'visibility' : icon = 'visibility_off';
          // Se crean y concatenan un contenedor con la imagen y nombre de cada registro.
          CBODY_ROWS.innerHTML += `
          <div class="row">
              <div class="col s10 m3">
                <div class="card">
                  <div class="card-image waves-effect waves-block waves-light">
                     <img src="${SERVER_URL}images/productos/${row.imagen_producto}" class="activator" >  
                  </div>
                  <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">${row.nombre_producto}
                      <div class="modal-footerD">
                        <a class="waves-effect waves-light btn modal-trigger" href="#Detalles">${row.descripcion_producto}</a>
                      </div>
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

/*
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
function openCreate() {
    // Se abre la caja de diálogo que contiene el formulario.
    SAVE_MODAL.open();
    // Se restauran los elementos del formulario.
    SAVE_FORM.reset();
    // Se asigna el título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Crear producto';
    // Se establece el campo de archivo como obligatorio.
    document.getElementById('archivo').required = true;
    // Llamada a la función para llenar el select del formulario. Se encuentra en el archivo components.js
    fillSelect(CATEGORIA_API, 'readAll', 'categoria');
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openUpdate(id) {
    // Se define un objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(PRODUCTO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        SAVE_MODAL.open();
        // Se restauran los elementos del formulario.
        SAVE_FORM.reset();
        // Se asigna el título para la caja de diálogo (modal).
        MODAL_TITLE.textContent = 'Actualizar producto';
        // Se establece el campo de archivo como opcional.
        document.getElementById('archivo').required = false;
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_producto;
        document.getElementById('codigo').value = JSON.dataset.codigo_producto;
        document.getElementById('nombre').value = JSON.dataset.nombre_producto;
        document.getElementById('precio').value = JSON.dataset.precio_producto;
        document.getElementById('descripcion').value = JSON.dataset.descripcion_producto;
        fillSelect(CATEGORIA_API, 'readAll', 'categoria', JSON.dataset.id_categoria);
        if (JSON.dataset.estado_producto) {
            document.getElementById('estado').checked = true;
        } else {
            document.getElementById('estado').checked = false;
        }
        // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
        M.updateTextFields();
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el producto de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_producto', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(PRODUCTO_API, 'delete', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillCard();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}