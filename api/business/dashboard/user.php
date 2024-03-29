<?php
require_once('../../entities/dto/user.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $user = new User;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario_privado'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['usuario_privado'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['usuario_privado'];
                } else {
                    $result['exception'] = 'Nombre de usuario indefinido';
                }
                break;
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
            case 'readProfile':
                if ($result['dataset'] = $user->readProfile()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'editProfile':
                $_POST = Validator::validateForm($_POST);
                if (!$user->setNombreEmpleado($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$user->setApellidoEmpleado($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$user->setCorreoEmpleado($_POST['correo'])) {
                    $result['exception'] = 'Teléfono incorrecto';
                } elseif (!$user->setTelefonoEmpleado($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecto';
                } elseif (!$user->setUsuarioPrivado($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($user->editProfile()) {
                    $result['status'] = 1;
                    $_SESSION['usuario_privado'] = $user->getUsuarioPrivado();
                    $result['message'] = 'Perfil modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'changePassword':
                $_POST = Validator::validateForm($_POST);
                if (!$user->setId($_SESSION['id_usuario_privado'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$user->checkPassword($_POST['actual'])) {
                    $result['exception'] = 'Clave actual incorrecta';
                } elseif ($_POST['nueva'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves nuevas diferentes';
                } elseif (!$user->setClave($_POST['nueva'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($user->changePassword()) {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña cambiada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $user->readAll()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['dataset'] = $user->readAll();
                    $result['status'] = 1;
                } elseif ($result['dataset'] = $user->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$user->setNombreEmpleado($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$user->setApellidoEmpleado($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$user->setDuiEmpleado($_POST['dui'])) {
                    $result['exception'] = 'DUI incorrecto';
                } elseif (!$user->setCorreoEmpleado($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$user->setTelefonoEmpleado($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecto';
                } elseif (!$user->setUsuarioPrivado($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$user->setClave($_POST['clave'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($user->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$user->setId($_POST['id_usuario_privado'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $user->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$user->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$user->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif (!$user->setNombreEmpleado($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$user->setApellidoEmpleado($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$user->setDuiEmpleado($_POST['dui'])) {
                    $result['exception'] = 'Dui incorrecto';
                } elseif (!$user->setCorreoEmpleado($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$user->setTelefonoEmpleado($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecto';
                } elseif (!$user->setUsuarioPrivado($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$user->setAcceso(isset($_POST['acceso']) ? 1 : 0)) {
                    $result['exception'] = 'Acceso incorrecto';
                } elseif ($user->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if ($_POST['id_usuario_privado'] == $_SESSION['id_usuario_privado']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                } elseif (!$user->setId($_POST['id_usuario_privado'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$user->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif ($user->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readUsers':
                if ($user->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    $result['exception'] = 'Debe crear un usuario para comenzar';
                }
                break;
            case 'signup':
                $_POST = Validator::validateForm($_POST);
                if (!$user->setNombreEmpleado($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$user->setApellidoEmpleado($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$user->setDuiEmpleado($_POST['dui'])) {
                    $result['exception'] = 'DUI incorrecto';
                } elseif (!$user->setCorreoEmpleado($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$user->setTelefonoEmpleado($_POST['telefono'])) {
                    $result['exception'] = 'Telefono incorrecto';
                } elseif (!$user->setUsuarioPrivado($_POST['usuario-pu'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$user->setClave($_POST['clave-pu'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($user->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario registrado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$user->checkUser($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($user->checkPassword($_POST['clave'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['id_usuario_privado'] = $user->getId();
                    $_SESSION['usuario_privado'] = $user->getUsuarioPrivado();
                } else {
                    $result['exception'] = 'Clave incorrecta';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
