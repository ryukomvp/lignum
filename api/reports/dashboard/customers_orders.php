<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/detailos.php');
require_once('../../entities/dto/customer.php');
require_once('../../entities/dto/orders.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Cantidad de pedidos por clientes');
// Se instancia el módelo Categoría para obtener los datos.
$product = new Product;

// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataProduct = $product->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(58, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(58, 10, 'Usuario', 1, 0, 'C', 1);
    $pdf->cell(58, 10, 'Cantidad', 1, 0, 'C', 1);


    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataProduct as $rowProduct) {
        // Se imprime una celda con el nombre del pedido.
        $orders = new Order;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($orders->setProducto($rowProduct['id_producto'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataDetails = $details->report()) {
                // Se recorren los registros fila por fila.
                foreach ($dataDetails as $rowDetails) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(30, 10, $pdf->encodeString($rowCustomers['nombre_cliente']), 1, 0);
                    $pdf->cell(30, 10, $pdf->encodeString($rowCustomers['usuario_publico']), 1, 0);
                    $pdf->cell(30, 10, $rowDetails['cantidad'], 1, 0);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la categoría'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Order incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay ordenes para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'products_orders.pdf');
