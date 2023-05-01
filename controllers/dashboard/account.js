/*
*   Controlador de uso general en las páginas web del sitio privado.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'business/dashboard/user.php';
// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const FOOTER = document.querySelector('footer');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USER_API, 'getUser');
    console.log(USER_API);
    // Se verifica si el usuario está autenticado, de lo contrario se envía a iniciar sesión.
    if (JSON.session) {
        // Se comprueba si existe un alias definido para el usuario, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            HEADER.innerHTML = `
                <div class="navbar-fixed">
                    <nav>
                        <div class="nav-wrapper">
                            <a href="main.html" class="brand-logo"><i class="material-icons">polymer</i></a>
                            <a href="#" data-target="menu-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                            <ul id="nav-mobile" class="right hide-on-med-and-down">
                                <li><a href="#" class="tooltipped" data-tooltip="Inicio de la página"><i
                                    class="material-icons">arrow_upward</i></a></li>
                                <li><a href="../../views/dashboard/profile.html" class="tooltipped" data-tooltip="Editar perfil"><i
                                    class="material-icons">account_circle</i></a></li>
                                <li><a onclick="logOut()" class="tooltipped" data-tooltip="Cerrar sesión"><i class="material-icons">exit_to_app</i></a></li>
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
            // Se inicializa el componente Dropdown para que funcione la lista desplegable en los menús.
            // M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'));
            // Se inicializa el componente Sidenav para que funcione la navegación lateral.
            // M.Sidenav.init(document.querySelectorAll('.sidenav'));
            // Inicialización del componente tooltiped
            M.Tooltip.init(document.querySelectorAll('.tooltipped'));
        } else {
            sweetAlert(3, JSON.exception, false, 'index.html');
        }
    } else {
        // Se comprueba si la página web es la principal, de lo contrario se direcciona a iniciar sesión.
        if (location.pathname == '/lignum/views/dashboard/index.html') {
            HEADER.innerHTML = `
                <div class="navbar-fixed">
                    <nav>
                        <div class="nav-wrapper center-align">
                            <a class="brand-logo"><i class="material-icons">polymer</i></a>
                        </div>
                    </nav>
                </div>
            `;
            FOOTER.innerHTML = `
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
            `;
            // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
            M.Tooltip.init(document.querySelectorAll('.tooltipped'));
        } else {
            location.href = 'index.html';
        }
    }
});

// inicializacion de tooltip
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.tooltipped');
    var instances = M.Tooltip.init(elems);
  });
  
  // inicializacion de ventana modal
//   document.addEventListener('DOMContentLoaded', function() {
//     var elems = document.querySelectorAll('.modal');
//     var instances = M.Modal.init(elems);
//   });
  
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

  // inicializacion de date picker
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems);
  });