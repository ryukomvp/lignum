// Archivo para crear la plantilla del sitio privado

// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const FOOTER = document.querySelector('footer');

document.addEventListener('DOMContentLoaded', async () => {
    HEADER.innerHTML = `
    <div class="navbar-fixed">
        <nav>
          <div class="nav-wrapper">
            <a href="main.html" class="brand-logo"><img src="/resources/img/2.png" alt=""></a>
            <a href="#" data-target="menu-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
              <li><a href="#" class="tooltipped" data-position="bottom" data-tooltip="Inicio de la página"><i
                    class="material-icons">arrow_upward</i></a></li>
              <li><a href="login.html" class="tooltipped" data-position="bottom" data-tooltip="Perfil del usuario"><i
                    class="material-icons">account_circle</i></a></li>
            </ul>
          </div>
        </nav>
        <!-- menu para dispositivos con pantalla pequeña -->
        <ul class="sidenav" id="menu-mobile">
          <li><a href="catalogue.html">Catalogo</a></li>
          <li><a href="shopping_cart.html">Carrito</a></li>
          <li><a href="login.html">Cuenta</a></li>
        </ul>
      </div>
    `;
})