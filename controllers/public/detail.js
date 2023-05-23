//Constantes para completar la ruta de las API
const PRODUCTO_API = 'business/public/products.php';
const PEDIDO_API = 'business/public/dashboard/order.php';
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
        document.getElementById('imagen').src = SERVER_URL.concat('images/products/', JSON.dataset.foto);
        document.getElementById('nombre').textContent = JSON.dataset.nombre_producto;
        document.getElementById('descripcion').textContent = JSON.dataset.descripcion_producto;
        document.getElementById('precio').textContent = JSON.dataset.precio_producto;
        document.getElementById('id_producto').value = JSON.dataset.id_producto;
    }else{
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        document.getElementById('title').textContent = JSON.exception;
        // Se limpia el contenido cuando no hay datos para mostrar.
        document.getElementById('detalle').innerHTML = '';
    }
});

