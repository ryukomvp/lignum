//Constante para completar la ruta de la api.
const CATEGORIA_API = 'business/dashboard/categories.php';
//Constante para establecer el contenedor de categorias
const CATEGORIAS = document.getElementById('categories');
// Constante tipo objeto para establecer las opciones del componente Slider.
const OPTIONS = {
    height: 300
}
// Se inicializa el componente Slider para que funcione el carrusel de imágenes.
M.Slider.init(document.querySelectorAll('.slider'), OPTIONS);

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener las categorías disponibles.
    const JSON = await dataFetch(CATEGORIA_API, 'readAll');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el contenedor de categorías.
        CATEGORIAS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se establece la página web de destino con los parámetros.
            url = `articles.html?id=${row.id_categoria}&nombre=${row.nombre_categoria}`;
            // Se crean y concatenan las tarjetas con los datos de cada categoría.
            CATEGORIAS.innerHTML += `
                <div class="col s12 m4">
                    <div class="card hoverable">
                        <div class="card-image">
                            <img class="materialboxed" src="${SERVER_URL}images/categorias/${row.imagen_producto}" class="activator">
                            <a href="${url}" class="tooltipped" data-tooltip="Ver detalle">
                                    <i class="material-icons">info</i>
                                </a>
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4">
                                <b>${row.nombre_producto}</b>
                            </span>
                        </div>
                    </div>
                </div>
            `;
        });
        // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
        M.Tooltip.init(document.querySelectorAll('.tooltipped'));
    } else {
        // Se asigna al título del contenido de la excepción cuando no existen datos para mostrar.
        document.getElementById('title').textContent = JSON.exception;
    }
});