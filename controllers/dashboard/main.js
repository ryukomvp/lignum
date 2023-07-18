//Constante para completar la ruta de la API
const PRODUCTO_API = 'business/dashboard/products.php';
const BIENVENIDA = document.getElementById('bienvenida');

document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USER_API, 'getUser');
    console.log(USER_API);
    BIENVENIDA.innerHTML = `
        <h1 class="center-align">Bienvenido <b>${JSON.username}</b></h1>
    `;

    graficaBarProveedor();
    graficaPieMaterial();
    graficaDonaProductos();
});

async function graficaBarProveedor() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, 'productosProveedor');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let proveedores = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            proveedores.push(row.nombre_proveedor);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart1', proveedores, cantidades, 'Cantidad de productos', 'Cantidad de productos por proveedor');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.exception);
    }
}

async function graficaPieMaterial() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, 'productosMaterial');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let materiales = [];
        let porcentajes = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            materiales.push(row.tipo_material);
            porcentajes.push(row.porcentaje);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        pieGraph('chart2', materiales, porcentajes, 'Porcentaje de productos por material');
    } else {
        document.getElementById('chart2').remove();
        console.log(DATA.exception);
    }
}

async function graficaDonaProductos() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, 'productosVendidos');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let ventas = [];
        let porcentaje2 = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            ventas.push(row.nombre_producto);
            porcentaje2.push(row.porcentaje);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        donutGraph('chart3', ventas, porcentaje2, '5 Productos mas vendidos del mes')
    } else {
        document.getElementById('chart3').remove();
        console.log(DATA.exception);
    }
}
