//Constante para completar la ruta de la API
const PRODUCTO_API = 'business/dashboard/products.php';
//Constante tipo objeto para obtener los parametros disponibles en la URL
const PARAMS = new URLSearchParams(location.search);
//Constantes para establecer el contenido principal de la pagina web
const TITULO = document.getElementById('title');
const PRODUCTOS = document.getElementById('productos');

//Metodo manejador de eventos para cuando el documento ha cargado
document.addEventListener('DOMContentLoaded', async () => {
    //Se define un objeto con los datos de la categoria seleccionada
    const FORM = new FormData();
    FORM.append('id_categoria', PARAMS.get('id'));
    //Peticion para solicitar los productos de la categoria seleccionada
    const JSON = await dataFetch(PRODUCTO_API, 'readProductosCategoria', FORM);
    if(JSON.status){
        //Se inicializa el contenedor de productos
        PRODUCTOS.innerHTML
    }
})
