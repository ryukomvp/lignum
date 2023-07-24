<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/user.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Usuarios por acceso');
// Se instancia el módelo Categoría para obtener los datos.
$usuario = new User;
$dataAcceso = array('Permitido' => 1, 'Denegado' => 0);

// Se establece un color de relleno para los encabezados.
$pdf->setFillColor(175);
// Se establece la fuente para los encabezados.
$pdf->setFont('Times', 'B', 11);
// Se imprimen las celdas con los encabezados.
$pdf->cell(93, 10, 'Empleado', 1, 0, 'C', 1);
$pdf->cell(46.5, 10, 'DUI', 1, 0, 'C', 1);
$pdf->cell(46.5, 10, 'Usuario', 1, 1, 'C', 1);

// Se establece un color de relleno para mostrar el nombre de la categoría.
$pdf->setFillColor(225);
// Se establece la fuente para los datos de los productos.
$pdf->setFont('Times', '', 11);
// Se recorren los registros fila por fila.
foreach ($dataAcceso as $indice => $valor) {
    // Se imprime una celda con el titulo del acceso.
    $pdf->cell(0, 10, $pdf->encodeString('Acceso: ' . $indice), 1, 1, 'C', 1);
    // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
    if ($usuario->setAcceso($valor)) {
        // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
        if ($dataUsuarios = $usuario->usuariosAcceso()) {
            // Se recorren los registros fila por fila.
            foreach ($dataUsuarios as $rowUsuario) {
                // Se imprimen las celdas con los datos de los productos.
                $pdf->cell(93, 10, $pdf->encodeString($rowUsuario['nombre_empleado']), 1, 0);
                $pdf->cell(46.5, 10, $rowUsuario['dui_empleado'], 1, 0);
                $pdf->cell(46.5, 10, $pdf->encodeString($rowUsuario['usuario_privado']), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('No hay usuarios con este tipo de acceso'), 1, 1);
        }
    } else {
        $pdf->cell(0, 10, $pdf->encodeString('Acceso incorrecto o inexistente'), 1, 1);
    }
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'productos.pdf');

// ($rowUsuario['acceso']) ? $acceso = 'Permitido' : $acceso = 'Denegado';