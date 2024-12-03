<?php
require_once "../config/conexion.php";
$titulo_reporte = 'Reporte de Pedidos'; // Valor predeterminado

// Verificar si se ha seleccionado un tipo de reporte
if (isset($_GET['reporte'])) {
    $tipo_reporte = $_GET['reporte'];
    switch ($tipo_reporte) {
        case 'pedidos':
            $titulo_reporte = 'Reporte de Pedidos';
            $query = "SELECT * FROM pedidos";
            break;
        case 'clientes':
            $titulo_reporte = 'Reporte de Clientes';
            $query = "SELECT * FROM clientes";
            break;
        case 'productos': // Agrega el caso para el reporte de productos
            $titulo_reporte = 'Reporte de Productos';
            $query = "SELECT * FROM productos";
            break;
        default:
            break;
    }

    $results_per_page = 80; // Número de registros por página
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    $start_index = ($page - 1) * $results_per_page;
    $query .= " LIMIT $start_index, $results_per_page";

    $result = mysqli_query($conexion, $query);
    if (!$result){
        die(mysqli_error($conexion));
    }
}
include("includes/header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
 
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
    
</head>
<body>
  
    <div class="container">
        <h1><?php echo $titulo_reporte; ?></h1>
        <div class="text-center mt-4">
        <a href="reportes.php?reporte=pedidos" class="btn btn-primary">Reporte de Pedidos</a>
        <a href="reportes.php?reporte=clientes" class="btn btn-primary">Reporte de Clientes</a>
        <a href="reportes.php?reporte=productos" class="btn btn-primary">Reporte de Productos</a>
        </div>
        <?php
        if (isset($_GET['reporte'])) {
            ?>
            <div class="container mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <?php
                            switch ($tipo_reporte) {
                                case 'pedidos':
                                    echo '<th>ID Pedido</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Correo Electrónico</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Tipo de Pago</th>
                                    <th>Total a Pagar</th>
                                    <th>Fecha de Pedido</th>';
                                    break;
                                case 'clientes':
                                    echo '<th>ID Cliente</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>';
                                    break;
                                case 'productos': 
                                    echo '<th>ID Producto</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Precio Normal</th>
                                    <th>Precio Rebajado</th>
                                    <th>Cantidad</th>
                                    <th>Categoría</th>';
                                    break;
                                default:
                                    break;
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($data = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <?php
                                switch ($tipo_reporte) {
                                    case 'pedidos':
                                        echo '<td>' . $data['id_pedido'] . '</td>
                                        <td>' . $data['nombre'] . '</td>
                                        <td>' . $data['apellido'] . '</td>
                                        <td>' . $data['correo_electronico'] . '</td>
                                        <td>' . $data['telefono'] . '</td>
                                        <td>' . $data['direccion'] . '</td>
                                        <td>' . $data['tipo_pago'] . '</td>
                                        <td>' . $data['total_pagar'] . '</td>
                                        <td>' . $data['fecha_pedido'] . '</td>';
                                        break;
                                    case 'clientes':
                                        echo '<td>' . $data['id_cliente'] . '</td>
                                        <td>' . $data['nombre'] . '</td>
                                        <td>' . $data['telefono'] . '</td>
                                        <td>' . $data['direccion'] . '</td>';
                                        break;
                                    case 'productos': 
                                        echo '<td>' . $data['id'] . '</td>
                                        <td>' . $data['nombre'] . '</td>
                                        <td>' . $data['descripcion'] . '</td>
                                        <td>' . $data['precio_normal'] . '</td>
                                        <td>' . $data['precio_rebajado'] . '</td>
                                        <td>' . $data['cantidad'] . '</td>
                                        <td>' . $data['id_categoria'] . '</td>';
                                        break;
                                    default:
                                        break;
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>
