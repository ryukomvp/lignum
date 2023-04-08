// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const FOOTER = document.querySelector('footer');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USER_API, 'getUser');
    // Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
   // Archivo para crear la plantilla del sitio privado

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
    FOOTER.innerHTML = `
    <div class="page-footer">
      <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">Dashboard</h5>
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
    </div>
  `;
})

// inicializacion de tooltip
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.tooltipped');
  var instances = M.Tooltip.init(elems);
});

// inicializacion de ventana modal
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.modal');
  var instances = M.Modal.init(elems);
});

// inicializacion de selecionador
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('select');
  var instances = M.FormSelect.init(elems);
});

// inicializacion de menu para pantallas pequeñas
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.sidenav');
  var instances = M.Sidenav.init(elems);
});
    // Se declara e inicializa una constante para obtener un elemento del arreglo de forma aleatoria.
    const ELEMENT = Math.floor(Math.random() * IMAGES.length);
});