// Archivo para crear la plantilla del sitio privado

// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const FOOTER = document.querySelector('footer');

document.addEventListener('DOMContentLoaded', async () => {
    HEADER.innerHTML = `
      <div class="navbar-fixed">
          <nav>
            <div class="nav-wrapper">
              <a href="../../views/dashboard/main.html" class="brand-logo"><img src="../../resources/img/2.png" alt=""></a>
              <a href="#" data-target="menu-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
              <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="#" class="tooltipped" data-position="bottom" data-tooltip="Inicio de la página"><i
                      class="material-icons">arrow_upward</i></a></li>
                <li><a href="../../views/dashboard/index.html" class="tooltipped" data-position="bottom" data-tooltip="Perfil del usuario"><i
                      class="material-icons">account_circle</i></a></li>
              </ul>
            </div>
          </nav>
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