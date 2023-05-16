<?php
require_once('../../entities/dto/customer.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $customer = new Customer;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'recaptcha' => 0, 'message' => null, 'exception' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['id_cliente'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['id_cliente'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['usuario_publico'];
                } else {
                    $result['exception'] = 'nombre de usuario indefinido';
                }
                break;
            case 'readProfile':
                if ($result['dataset'] = $customer->readProfile()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
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
            case 'getAllGender':
                if ($result['dataset'] = $customer->readAllGender()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No se encontraron géneros registrados';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el cliente no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getAllGender':
                if ($result['dataset'] = $customer->readAllGender()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No se encontraron géneros registrados';
                }
                break;
            case 'signup':
                $_POST = Validator::validateForm($_POST);
                $secretKey = '6LdBzLQUAAAAAL6oP4xpgMao-SmEkmRCpoLBLri-';
                $ip = $_SERVER['REMOTE_ADDR'];

                $data = array('secret' => $secretKey, 'response' => $_POST['g-recaptcha-response'], 'remoteip' => $ip);

                $options = array(
                    'http' => array('header'  => "Content-type: application/x-www-form-urlencoded\r\n", 'method' => 'POST', 'content' => http_build_query($data)),
                    'ssl' => array('verify_peer' => false, 'verify_peer_name' => false)
                );

                $url = 'https://www.google.com/recaptcha/api/siteverify';
                $context  = stream_context_create($options);
                $response = file_get_contents($url, false, $context);
                $captcha = json_decode($response, true);

                if (!$captcha['success']) {
                    $result['recaptcha'] = 1;
                    $result['exception'] = 'No eres humano';
                } elseif (!$customer->setNombreCliente($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$customer->setApellidoCliente($_POST['apellido'])) {
                    $result['exception'] = 'Apellido incorrecta';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$customer->setFoto($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!$customer->setDuiCliente($_POST['dui'])) {
                    $result['exception'] = 'DUI incorrecto';
                } elseif (!$customer->setCorreoCliente($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecta';
                } elseif (!$customer->setTelefonoCliente($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecta';
                } elseif (!isset($_POST['genero'])) {
                    $result['exception'] = 'Seleccione una genero';
                } elseif (!$customer->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero incorrecto';
                } elseif (!$customer->setDireccionCliente($_POST['direccion'])) {
                    $result['exception'] = 'Dirección incorrecta';
                } elseif (!$customer->setUsuarioPublico($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($_POST['clave'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$customer->setClave($_POST['clave'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($customer->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $customer->getRuta(), $customer->getFoto())) {
                        $result['message'] = 'Cliente creado correctamente';
                    } else {
                        $result['message'] = 'Cliente creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$customer->checkUser($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$customer->getAcceso()) {
                    $result['exception'] = 'La cuenta ha sido desactivada';
                } elseif ($customer->checkPassword($_POST['clave'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['id_cliente'] = $customer->getIdCliente();
                    $_SESSION['usuario_publico'] = $customer->getUsuarioPublico();
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
