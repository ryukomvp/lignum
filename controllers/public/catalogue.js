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
        PRODUCTOS.innerHTML = '';
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            PRODUCTOS.innerHTML += `
                <div class="col s12 m6 l4">
                    <div class="card hoverable">
                        <div class="card-image">
                            <img src="${SERVER_URL}images/productos/${row.imagen_producto}" class="materialboxed">
                            <a href="detail.html?id=${row.id_producto}" class="btn-floating halfway-fab waves-effect red tooltipped" data-tooltip="Ver detalle">
                                <i class="material-icons">more_horiz</i>
                            </a>
                        </div>
                        <div class="card-content">
                            <span class="card-title">${row.nombre_producto}</span>
                            <p>Precio(US$) ${row.precio_producto}</p>
                        </div>
                    </div>
                </div>
            `;
        });
        // Se asigna como título la categoría de los productos.
        TITULO.textContent = PARAMS.get('nombre');
        // Se inicializa el componente Material Box para que funcione el efecto Lightbox.
        M.Materialbox.init(document.querySelectorAll('.materialboxed'));
        // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
        M.Tooltip.init(document.querySelectorAll('.tooltipped'));
    }else{
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        TITULO.textContent = JSON.exception;
    }
});
