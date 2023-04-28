// Constantes para completar las rutas de la API.
const RATINGS_API = 'business/dashboard/ratings.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para establecer el contenido de la tabla.
const RATINGS = document.getElementById('ratings');
const RECORDS = document.getElementById('records');
// Constante tipo objeto para establecer las opciones del componente Modal.
const OPTIONS = {
    dismissible: false
}
// Se inicializa el componente Modal para que funcionen las cajas de diálogo.
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
    const JSON = await dataFetch(RATINGS_API, action, FORM);
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
    RATINGS.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(RATINGS_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {

        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {

            switch (row.puntaje) {
                case 1:
                    RATINGS.innerHTML += `
         
                <div id="contenedor">
                    <div id="arriba">
                        <h5>${row.nombre_producto}</h5>
                        <p>${row.comentario}</p>
                    </div>
                    <div id="abajo">
                        <div id="horizontal">
                            <div class="left_align">
                                <h6 id = "fecha">Fecha: ${row.fecha}<h6>
                                <h6 id ="cliente">Cliente: ${row.nombre_cliente}<h6>
                            </div>
                            <div class="right_align">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-llena-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-rating-basio-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-rating-basio-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-rating-basio-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-rating-basio-30.png">
                            </div>
                        </div>
                        <p>
                            <div class="switch">
                                <span>Estado:</span>
                                <label>
                                    <input id="estado" type="checkbox" name="estado" checked>
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </p>
                        <div class="boton-ratings">
                            <button onclick="openUpdate(${row.id_valoracion})" class=" waves-effect waves-green btn-flat tooltipped" data-tooltip="Guardar">
                                <i class="material-icons">save</i>
                            </button>
                        </div>
                    </div>
                </div>
       
            `;
                    break;
                case 2:
                    RATINGS.innerHTML += `
         
                <div id="contenedor">
                    <div id="arriba">
                        <h5>${row.nombre_producto}</h5>
                        <p>${row.comentario}</p>
                    </div>
                    <div id="abajo">
                        <div id="horizontal">
                            <div class="left_align">
                                <h6 id = "fecha">Fecha: ${row.fecha}<h6>
                                <h6 id ="cliente">Cliente: ${row.nombre_cliente}<h6>
                            </div>
                            <div class="right_align">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-llena-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-llena-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-rating-basio-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-rating-basio-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-rating-basio-30.png">
                            </div>
                        </div>
                         <p>
                                <div class="switch">
                                    <span>Estado:</span>
                                    <label>
                                        <input id="estado" type="checkbox" name="estado" checked>
                                        <span class="lever"></span>
                                    </label>
                                </div>
                        </p>
                        <div class="boton-ratings">
                            <button type="submit" class=" waves-effect waves-green btn-flat guardar tooltipped"data-tooltip="Guardar">
                                <i class="material-icons">save</i>
                            </button>
                        </div>
                    </div>
                </div>
            `;

                    break;
                case 3:
                    RATINGS.innerHTML += `
         
                <div id="contenedor">
                    <div id="arriba">
                        <h5>${row.nombre_producto}</h5>
                        <p>${row.comentario}</p>
                    </div>
                    <div id="abajo">
                        <div id="horizontal">
                            <div class="left_align">
                                <h6 id = "fecha">Fecha: ${row.fecha}<h6>
                                <h6 id ="cliente">Cliente: ${row.nombre_cliente}<h6>
                            </div>
                            <div class="right_align">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-llena-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-llena-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-llena-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-rating-basio-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-rating-basio-30.png">
                            </div>
                        </div>
                         <p>
                            <div class="switch">
                                <span>Estado:</span>
                                <label>
                                    <input id="estado" type="checkbox" name="estado" checked>
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </p>
                        <div class="boton-ratings">
                            <button type="submit" class=" waves-effect waves-green btn-flat guardar tooltipped"data-tooltip="Guardar">
                                <i class="material-icons">save</i>
                            </button>
                        </div>
                    </div>
                </div>
       
            `;
                    break;
                case 4:
                    RATINGS.innerHTML += `

                <div id="contenedor">
                    <div id="arriba">
                        <h5>${row.nombre_producto}</h5>
                        <p>${row.comentario}</p>
                    </div>
                    <div id="abajo">
                        <div id="horizontal">
                            <div class="left_align">
                                <h6 id = "fecha">Fecha: ${row.fecha}<h6>
                                <h6 id ="cliente">Cliente: ${row.nombre_cliente}<h6>
                            </div>
                            <div class="right_align">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-llena-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-llena-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-llena-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-llena-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-rating-basio-30.png">
                            </div>
                        </div>
                         <p>
                            <div class="switch">
                                <span>Estado:</span>
                                <label>
                                    <input id="estado" type="checkbox" name="estado" checked>
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </p>
                        <div class="boton-ratings">
                            <button type="submit" class=" waves-effect waves-green btn-flat guardar tooltipped"data-tooltip="Guardar">
                                <i class="material-icons">save</i>
                            </button>
                        </div>
                    </div>
                </div>
                    `;

                    break;
                case 5:
                    RATINGS.innerHTML += `

                <div id="contenedor">
                    <div id="arriba">
                        <h5>${row.nombre_producto}</h5>
                        <p>${row.comentario}</p>
                    </div>
                    <div id="abajo">
                        <div id="horizontal">
                            <div class="left_align">
                                <h6 id = "fecha">Fecha: ${row.fecha}<h6>
                                <h6 id ="cliente">Cliente: ${row.nombre_cliente}<h6>
                            </div>
                            <div class="right_align">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-llena-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-llena-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-llena-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-llena-30.png">
                                <img class="icons_ratings" src="../../resources/img/iconos/Icono-estrella-llena-30.png">
                            </div>
                        </div>
                         <p>
                            <div class="switch">
                                <span>Estado:</span>
                                <label>
                                    <input id="estado" type="checkbox" name="estado" checked>
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </p>
                        <div class="boton-ratings">
                            <button type="submit" class=" waves-effect waves-green btn-flat guardar tooltipped"data-tooltip="Guardar">
                                <i class="material-icons">save</i>
                            </button>
                        </div>
                    </div>
                </div>
                    `;
                    break;
                default:
                    $result['exception'] = 'Acción no disponible dentro de la sesión';
            }
        });
        // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
        M.Tooltip.init(document.querySelectorAll('.tooltipped'));
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

async function openUpdate(id) {
    const RESPONSE = await confirmAction('¿Desea actualizar el estado de la valoracion?');
    if (RESPONSE) {
        // Se define un objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(RATINGS_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    console.log(row.id_valoracion);
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        SAVE_MODAL.open();
        // Se restauran los elementos del formulario.
        SAVE_FORM.reset();
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_valoracion;
        document.getElementById('puntaje').value = JSON.dataset.puntaje;
        document.getElementById('comentario').value = JSON.dataset.comentario;
        document.getElementById('pedido').value = JSON.dataset.id_detalle_pedido;
        if (JSON.dataset.estado) {
            document.getElementById('estado').checked = true;
        } else {
            document.getElementById('estado').checked = false;
        }
        // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
        M.updateTextFields();
        console.log(JSON);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
    }
    
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar la categoría de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_valoracion', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(RATINGS_API, 'delete', FORM);
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
*   Función para abrir el reporte de RATINGS de una categoría.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
// function openReport(id) {
//     // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
//     const PATH = new URL(`${SERVER_URL}reports/dashboard/RATINGS_categoria.php`);
//     // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
//     PATH.searchParams.append('id_categoria', id);
//     // Se abre el reporte en una nueva pestaña del navegador web.
//     window.open(PATH.href);
// }