//Constante para completar la ruta de la api.
const CATEGORIA_API = 'business/dashboard/categories.php';
//Constante para establecer el contenedor de categorias
const CATEGORIAS = document.getElementById('categorias');
// Constante tipo objeto para establecer las opciones del componente Slider.
const OPTIONS = {
    height: 300
}

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
            // Se crean y concatenan las tarjetas con los datos de cada categoría.
            CATEGORIAS.innerHTML += `
                <div class="col s12 m4">
                    <div class="card grey darken-4">
                    <div class="card-content white-text">
                        <span class="card-title center-align">${row.categoria}</span>
                        <p>Aqui iria la img de la categoria</p>
                    </div>
                        <div class="card-action">
                            <p class="white-text">${row.descripcion}</p>
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

// Se inicializa el componente Slider para que funcione el carrusel de imágenes.
M.Slider.init(document.querySelectorAll('.slider'), OPTIONS);