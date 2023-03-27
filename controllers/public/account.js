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
                    <a href="index.html" class="brand-logo"><img src="/resources/img/2.png" alt=""></a>
                    <a href="#" data-target="menu-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="#" class="tooltipped" data-position="bottom" data-tooltip="Inicio de la página"><i
                                    class="material-icons">arrow_upward</i></a></li>
                        <li><a href="catalogue.html" class="tooltipped" data-position="bottom"
                                data-tooltip="Catalogo"><i class="material-icons">library_books</i></a></li>
                        <li><a href="shopping_cart.html" class="tooltipped" data-position="bottom"
                                data-tooltip="Carrito de compras"><i class="material-icons">shopping_cart</i></a></li>
                        <li><a href="login.html" class="tooltipped" data-position="bottom"
                                data-tooltip="Perfil del usuario"><i class="material-icons">account_circle</i></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- menu para dispositivos con pantallas pequeños -->
        <ul class="sidenav" id="menu-mobile">
            <li><a href="catalogue.html">Catalogo</a></li>
            <li><a href="shopping_cart.html">Carrito</a></li>
            <li><a href="login.html">Cuenta</a></li>
        </ul>
    `;
    })
    FOOTER.innerHTML = `
        <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">Expertos en muebles</h5>
            </div>
        </div>
        </div>
        <div class=" footer-copyright">
        <div class="container">
            Lignum
            <a class="grey-text text-lighten-4 right" href="https://www.instagram.com/dnlhernandez_"
                target="_blank"><img src="https://img.icons8.com/material-outlined/24/FFFFFF/instagram-new--v1.png"/></a>
        </div>
        </div>
    `;