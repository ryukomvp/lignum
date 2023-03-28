// Archivo para crear la plantilla del sitio privado

// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const FOOTER = document.querySelector('footer');

document.addEventListener('DOMContentLoaded', async () => {
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
                    </ul>
                </div>
            </nav>
        </div>
        <!-- menu para dispositivos con pantallas pequeños -->
        <ul class="sidenav" id="menu-mobile">
            <li><a href="/views/public/catalogue.html">Catalogo</a></li>
            <li><a href="/views/public/shopping_cart.html">Carrito</a></li>
            <li><a href="/views/public/login.html">Cuenta</a></li>
        </ul>
    `;
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
})

// inicializacion para material box
document.addEventListener('DOMContentLoaded', function() {
var elems = document.querySelectorAll('.materialboxed');
var instances = M.Materialbox.init(elems);
});

// inicializacion de carrusel
document.addEventListener('DOMContentLoaded', function() {
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
document.addEventListener('DOMContentLoaded', function() {
var elems = document.querySelectorAll('.tooltipped');
var instances = M.Tooltip.init(elems);
});

// inicializacion de menu para pantallas pequeñas
document.addEventListener('DOMContentLoaded', function() {
var elems = document.querySelectorAll('.sidenav');
var instances = M.Sidenav.init(elems);
});