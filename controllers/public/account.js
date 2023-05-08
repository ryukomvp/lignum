/*
*   Controlador es de uso general en las páginas web del sitio público.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'business/public/customer.php';
// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const FOOTER = document.querySelector('footer');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USER_API, 'getUser');
    // Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
    if (JSON.session) {
        HEADER.innerHTML = `
            <!-- menu del sitio -->
            <div class="navbar-fixed">
                <nav>
                    <div class="nav-wrapper">
                        <a href="/views/public/index.html" class="brand-logo"><i class="material-icons">home</i></a>
                        <a href="#" data-target="menu-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                        <ul id="nav-mobile" class="right hide-on-med-and-down">
                            <li><a href="#" class="tooltipped" data-position="bottom" data-tooltip="Inicio de la página"><i
                                        class="material-icons">arrow_upward</i></a></li>
                            <li><a href="/views/public/catalogue.html" class="tooltipped" data-position="bottom"
                                    data-tooltip="Catalogo"><i class="material-icons">library_books</i></a></li>
                            <li><a href="/views/public/shopping_cart.html" class="tooltipped" data-position="bottom"
                                    data-tooltip="Carrito de compras"><i class="material-icons">shopping_cart</i></a></li>
                            <li><a href="/views/public/login.html" class="tooltipped" data-position="bottom"
                                    data-tooltip="Perfil del usuario"><i class="material-icons">account_circle</i></a></li>
                            <li><a onclick="logOut()"><i class="material-icons left">close</i>Cerrar sesión</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- menu para dispositivos con pantallas pequeños -->
            <ul class="sidenav" id="menu-mobile">
                <li><a href="/views/public/catalogue.html">Catalogo</a></li>
                <li><a href="/views/public/shopping_cart.html">Carrito</a></li>
                <li><a href="/views/public/login.html">Cuenta</a></li>
                <li><a onclick="logOut()"><i class="material-icons left">close</i>Cerrar sesión</a></li>
            </ul>
        `;
    } else {
        HEADER.innerHTML = `
        <!-- menu del sitio -->
        <div class="navbar-fixed">
            <nav>
                <div class="nav-wrapper">
                    <a href="/views/public/index.html" class="brand-logo"><i class="material-icons">home</i></a>
                    <a href="#" data-target="menu-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="#" class="tooltipped" data-position="bottom" data-tooltip="Inicio de la página"><i
                                    class="material-icons">arrow_upward</i></a></li>
                        <li><a href="/views/public/catalogue.html" class="tooltipped" data-position="bottom"
                                data-tooltip="Catalogo"><i class="material-icons">library_books</i></a></li>
                        <li><a href="/views/public/shopping_cart.html" class="tooltipped" data-position="bottom"
                                data-tooltip="Carrito de compras"><i class="material-icons">shopping_cart</i></a></li>
                        <li><a href="/views/public/login.html" class="tooltipped" data-position="bottom"
                                data-tooltip="Perfil del usuario"><i class="material-icons">account_circle</i></a></li>
                        <li><a href="login.html"><i class="material-icons left">login</i>Iniciar sesión</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- menu para dispositivos con pantallas pequeños -->
        <ul class="sidenav" id="menu-mobile">
            <li><a href="/views/public/catalogue.html">Catalogo</a></li>
            <li><a href="/views/public/shopping_cart.html">Carrito</a></li>
            <li><a href="/views/public/login.html">Cuenta</a></li>
            <li><a href="login.html"><i class="material-icons left">login</i>Iniciar sesión</a></li>
        </ul>
        `;
    }
    // Se establece el pie del encabezado.
    FOOTER.innerHTML = `
        <div class="page-footer">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5 class="white-text">Expertos en muebles</h5>
                    </div>
                </div>
            </div>
            <div class=" footer-copyright">
                <div class="container">
                    <a href="/views/public/about_us.html">Sobre Lignum</a>
                    <a class="grey-text text-lighten-4 right" href="https://www.instagram.com/dnlhernandez_"
                        target="_blank"><img src="https://img.icons8.com/material-outlined/24/FFFFFF/instagram-new--v1.png"/></a>
                </div>
            </div>
        </div>
    `;
    // Se inicializa el componente Sidenav para que funcione la navegación lateral.
    M.Sidenav.init(document.querySelectorAll('.sidenav'));
});

// inicializacion para material box
document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.materialboxed');
    var instances = M.Materialbox.init(elems);
});

// inicializacion de carrusel
document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.carousel');
    var instances = M.Carousel.init(elems, {
        duration: 500,
        indicators: true
    });
});

var instance = M.Carousel.init({
    fullWidth: true,
    indicators: true
})

// inicializacion para tooltip
document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.tooltipped');
    var instances = M.Tooltip.init(elems);
});

// inicializacion de menu para pantallas pequeñas
document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);
});