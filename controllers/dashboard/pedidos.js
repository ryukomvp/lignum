// Constante para completar la ruta de la API.
const PEDIDO_API = 'business/public/pedido.php';
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
// Se inicializa el componente Modal para que funcionen las cajas de diálogo.
M.Modal.init(document.querySelectorAll('.modal'), OPTIONS);
// Constante para establecer la caja de diálogo de cambiar producto.
const SAVE_MODAL = M.Modal.getInstance(document.getElementById('save-modal'));

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar los productos del carrito de compras.
    filltable();
});

SEARCH_FORM.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM);
    filltable(FORM);
});

SAVE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id_pedido').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM);
    const JSON = await dataFetch(PEDIDO_API, action, FORM);
    if (JSON.status){
        filltable();
        SAVE_MODAL.close();
        sweetAlert(1, JSON.message, true);
    }else{
        sweetAlert(2, JSON.message, false);
    }
});

async function filltable(form = null){
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    (form) ? action = 'search' : action = 'readAll';
    const JSON = await dataFetch(PEDIDO_API, action, form);
    if(JSON.status){
        JSON.dataFetch.forEach(row => {
            TBODY_ROWS.innerHTML += `
            <tr>
                <td>${row.codigo_pedido}</td>
                <td>${row.descripcion.pedido}</td>
                <td>${row.nombre_cliente}</td>
                <td>${row.estado_pedido}</td>
                <td>
                    <a onclick="openUpdate(${row.id_pedido})" class="btn waves-effect blue tooltipped"             data-tooltip="Actualizar">
                        <i class="material-icons">mode_edit</i>
                    </a>
                    <a onclick="openDelete(${row.id_pedido}" class="btn waves-effect red tooltipped" data-tooltip="Eliminar")><i class="material-icons">delete</a>
                    </td>
            <tr>
            `
        })
    }
}

