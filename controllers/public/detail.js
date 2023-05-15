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
document.addEventListener('DOMContentLoaded', async)