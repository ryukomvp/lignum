//Constantes para completar la ruta de las API
const PRODUCTO_API = 'business/public/products.php';
const PEDIDO_API = 'business/public/dashboard/order';
//Constante tipo objeto para obtener los parametros
const PARAMS = new URLSearchParams(location.search);
//Constante para establecer el formulario de agregar un producto al carrito de compras
const SHOPPING_FORM = document.getElementById('shopping_form');
//Se inicializa el componente Tooltip para que funcionen las sugerencias textuales
M.Tooltip.init(document.querySelectorAll('.tooltipped'));

//Metodo manejador de eventos para cuando el documento ha cargado
document.addEventListener('DOMContentLoaded', async () => {
    //Constante tipo objeto con los datos del producto seleccionado
    const FORM = new FormData();
    FORM.append('id_producto', PARAMS.get('id'));
    //Peticion para seleccionar los datos del producto seleccionado
    const JSON = await dataFetch(PRODUCTO_API, 'readOne', FORM);
    //Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepcion
    if(JSON.status){
        //Se colocan los datos en la pagina web de acuerdo con el producto seleccionado previamente
    }
}) 