// Constantes para completar las rutas de la API.
const CLIENTE_API = 'business/dashboard/cliente.php';
const GENERO_API = 'business/dashboard/genero.php';
const TIPO_CLIENTE_API = 'business/dashboard/tipo_cliente.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');
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
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});

// Método manejador de eventos para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
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
    const JSON = await dataFetch(CLIENTE_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
        // Se cierra la caja de diálogo.
        SAVE_MODAL.close();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
async function fillTable(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
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
            (row.acceso) ? icon = 'visibility' : icon = 'visibility_off';
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    // <td><img src="${SERVER_URL}images/clientes/${row.foto}" class="materialboxed" height="100"></td>
                    <td>${row.nombre_cliente}</td>
                    <td>${row.apellido_cliente}</td>
                    <td>${row.dui_cliente}</td>
                    <td>${row.correo_cliente}</td>
                    <td>${row.telefono_cliente}</td>
                    <td>${row.id_genero}</td>
                    <td>${row.id_tipo_cliente}</td>
                    <td>${row.direccion_cliente}</td>
                    <td>${row.usuario_publico}</td>
                    // <td><i class="material-icons">${icon}</i></td>
                    <td>
                        <a onclick="openUpdate(${row.id_cliente})" class="waves-effect waves-light btn tooltipped"
                            data-position="top" data-tooltip="Editar"><i class="material-icons">create</i>
                        </a>
                    </td>
                    <td>
                        <a onclick="openDelete(${row.id_cliente})" class="waves-effect waves-light btn tooltipped"
                            data-position="top" data-tooltip="Eliminar"><i class="material-icons">delete</i>
                        </a>
                    </td>
                </tr>
            `;
        });
        // Se inicializa el componente Material Box para que funcione el efecto Lightbox.
        M.Materialbox.init(document.querySelectorAll('.materialboxed'));
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
// function openCreate() {
//     // Se abre la caja de diálogo que contiene el formulario.
//     SAVE_MODAL.open();
//     // Se restauran los elementos del formulario.
//     SAVE_FORM.reset();
//     // Se asigna el título a la caja de diálogo.
//     MODAL_TITLE.textContent = 'Crear cliente';
//     // Se establece el campo de archivo como obligatorio.
//     document.getElementById('archivo').required = true;
//     // Llamada a la función para llenar el select del formulario. Se encuentra en el archivo components.js
//     fillSelect(CATEGORIA_API, 'readAll', 'categoria');
// }

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
    const JSON = await dataFetch(CLIENTE_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        SAVE_MODAL.open();
        // Se restauran los elementos del formulario.
        SAVE_FORM.reset();
        // Se asigna el título para la caja de diálogo (modal).
        MODAL_TITLE.textContent = 'Actualizar cliente';
        // Se establece el campo de archivo como opcional.
        document.getElementById('foto').required = false;
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_cliente;
        document.getElementById('nombre').value = JSON.dataset.nombre_cliente;
        document.getElementById('apellido').value = JSON.dataset.apellido_cliente;
        document.getElementById('dui').value = JSON.dataset.dui_cliente;
        document.getElementById('correo').value = JSON.dataset.correo_cliente;
        document.getElementById('telefono').value = JSON.dataset.telefono_cliente;
        fillSelect(GENERO_API, 'readAll', 'genero', JSON.dataset.id_genero);
        fillSelect(TIPO_CLIENTE_API, 'readAll', 'tipo_cliente', JSON.dataset.id_tipo_cliente);
        document.getElementById('direccion_cliente').value = JSON.dataset.direccion_cliente;
        document.getElementById('usuario_publico').value = JSON.dataset.usuario_publico;
        if (JSON.dataset.acceso) {
            document.getElementById('acceso').checked = true;
        } else {
            document.getElementById('acceso').checked = false;
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
    const RESPONSE = await confirmAction('¿Desea eliminar el cliente de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_cliente', id_cliente);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(CLIENTE_API, 'delete', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

/*
*   Función para abrir el reporte de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
// function openReport() {
//     // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
//     const PATH = new URL(`${SERVER_URL}reports/dashboard/productos.php`);
//     // Se abre el reporte en una nueva pestaña del navegador web.
//     window.open(PATH.href);
// }