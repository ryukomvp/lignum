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
        <!-- etiqueta para menu -->
        <div class="navbar-fixed">
          <nav>
            <div class="nav-wrapper">
              <a href="#" class="brand-logo"><img src="/resources/img/2.png" alt="" width="80px" height="80px"></a>
              <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="#" class="tooltipped" data-position="bottom" data-tooltip="Inicio de la página"><i
                      class="material-icons">arrow_upward</i></a></li>
                <li><a href="profile.html" class="tooltipped" data-position="bottom" data-tooltip="Perfil del usuario"><i
                      class="material-icons">account_circle</i></a></li>
              </ul>
            </div>
          </nav>
        </div>
        `;
    } else {
        HEADER.innerHTML = `
        <!-- etiqueta para menu -->
        <div class="navbar-fixed">
          <nav>
            <div class="nav-wrapper">
              <a href="#" class="brand-logo"><img src="/resources/img/2.png" alt="" width="80px" height="80px"></a>
              <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="#" class="tooltipped" data-position="bottom" data-tooltip="Inicio de la página"><i
                      class="material-icons">arrow_upward</i></a></li>
                <li><a href="profile.html" class="tooltipped" data-position="bottom" data-tooltip="Perfil del usuario"><i
                      class="material-icons">account_circle</i></a></li>
              </ul>
            </div>
          </nav>
        </div>
        `;
    }
    // Se establece el pie del encabezado.
    FOOTER.innerHTML = `
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <a href="about-us.html">
            <h5 class="white-text">Dashboard footer</h5>
          </a>
        </div>
      </div>
    </div>
    <div class=" footer-copyright">
      <div class="container">
        © 2014 Copyright Text
        <a class="grey-text text-lighten-4 right" href="https://www.instagram.com/dnlhernandez_" target="_blank">More
          Links</a>
      </div>
    </div>
    `;
    // Se inicializa el componente Sidenav para que funcione la navegación lateral.
    M.Sidenav.init(document.querySelectorAll('.sidenav'));
    // Se declara e inicializa una constante para obtener un elemento del arreglo de forma aleatoria.
    const ELEMENT = Math.floor(Math.random() * IMAGES.length);
});