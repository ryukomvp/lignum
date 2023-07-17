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

    graficaBar();
    graficaPie();
});

async function graficaBar() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, 'productosMaterial');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let materiales = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            materiales.push(row.tipo_material);
            cantidades.push(row.cantidad)
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart1', materiales, cantidades, 'Cantidad de productos', 'Cantidad de productos por material');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.exception);
    }
}

async function graficaPie() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, 'productosMaterial');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let proveedores = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            materiales.push(row.proveedor);
            cantidades.push(row.cantidad)
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart1', proveedores, cantidades, 'Cantidad de productos', 'Cantidad de productos por proveedor');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.exception);
    }
}
