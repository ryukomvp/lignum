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