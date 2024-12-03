<?php
require_once "config/conexion.php";

if (isset($_POST["total_pagar"]) && isset($_POST["productos"])) {
    $totalPagar = $_POST["total_pagar"];
    $productos = json_decode($_POST["productos"], true);

    // La fecha del pedido se tomará como la fecha actual del sistema
    $fechaPedido = date('Y-m-d');

    // Datos del cliente (aquí podrías obtenerlos de una sesión de usuario o un formulario)
    $idCliente = 1; // ¡Cambia esto al ID del cliente correspondiente!

    // Insertar el pedido en la tabla "pedidos"
    $queryInsertPedido = "INSERT INTO pedidos (fecha, costo_envio, monto, id_cliente, id_tipopago)
                          VALUES ('$fechaPedido', 0, $totalPagar, $idCliente, 1)";
    $resultInsertPedido = mysqli_query($conexion, $queryInsertPedido);
    if (!$resultInsertPedido) {
        echo "Error al insertar el pedido en la base de datos: " . mysqli_error($conexion);
        exit;
    }

    // Obtener el ID del último pedido insertado
    $idPedido = mysqli_insert_id($conexion);

    // Insertar los detalles del pedido en la tabla "detalles_pedido"
    foreach ($productos as $producto) {
        $idProducto = $producto["id"];
        $precioProducto = $producto["precio"];
        $cantidadProducto = $producto["cantidad"];

        $queryInsertDetalle = "INSERT INTO detalles_pedido (precio, cantidad, id_pedido, id_producto)
                               VALUES ($precioProducto, $cantidadProducto, $idPedido, $idProducto)";
        $resultInsertDetalle = mysqli_query($conexion, $queryInsertDetalle);
        if (!$resultInsertDetalle) {
            echo "Error al insertar el detalle del pedido en la base de datos: " . mysqli_error($conexion);
            exit;
        }
    }

    // En este punto, el pedido y sus detalles se han insertado correctamente en la base de datos.
    // Aquí podrías realizar alguna acción adicional, como enviar un correo electrónico de confirmación al cliente, etc.

    // Si llegamos a este punto, todo ha sido exitoso, así que podemos enviar una respuesta al frontend.
    echo "Pedido realizado exitosamente.";
} else {
    echo "Error: Datos de pedido incompletos.";
}
?>
