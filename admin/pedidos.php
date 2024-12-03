<?php
require_once "../config/conexion.php";

// Verificar si se ha enviado el formulario de actualización
if (isset($_POST['pedido_id']) && isset($_POST['estado_pedido'])) {
    $pedido_id = $_POST['pedido_id'];
    $estado_pedido = $_POST['estado_pedido'];

    // Actualizar el estado del pedido
    $query = "UPDATE pedidos SET estado = '$estado_pedido' WHERE id_pedido = $pedido_id";
    $result = mysqli_query($conexion, $query);
    if (!$result) {
        die(mysqli_error($conexion));
    }

    // Redirigir después de actualizar
    header('Location:?action=list');
    exit;
}

// Consulta para obtener los pedidos
$query = "SELECT id_pedido, nombre, apellido, correo_electronico, telefono, direccion, 
                 tipo_pago, total_pagar, fecha_pedido, estado 
          FROM pedidos";
$result = mysqli_query($conexion, $query);
if (!$result) {
    die(mysqli_error($conexion));
}

// Verificar que $result sea un objeto mysqli_result antes de usar mysqli_fetch_all
if ($result instanceof mysqli_result) {
    $pedidos = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    die("Error en la consulta: " . mysqli_error($conexion));
}

include("includes/header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1>Lista de Pedidos</h1>
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Tipo de Pago</th>
                    <th>Total a Pagar</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido) { ?>
                    <tr>
                        <td><?php echo $pedido['id_pedido']; ?></td>
                        <td><?php echo $pedido['nombre']; ?></td>
                        <td><?php echo $pedido['apellido']; ?></td>
                        <td><?php echo $pedido['correo_electronico']; ?></td>
                        <td><?php echo $pedido['telefono']; ?></td>
                        <td><?php echo $pedido['direccion']; ?></td>
                        <td><?php echo $pedido['tipo_pago']; ?></td>
                        <td><?php echo $pedido['total_pagar']; ?></td>
                        <td><?php echo $pedido['fecha_pedido']; ?></td>
                        <td class="text-center <?php echo $pedido['estado'] === 'Entregado' ? 'bg-success text-white' : ($pedido['estado'] === 'Pendiente' ? 'bg-danger text-white' : 'bg-warning text-dark'); ?>">
                            <?php echo $pedido['estado']; ?>
                        </td>
                        <td>
                            <form action="pedidos.php" method="POST">
                                <input type="hidden" name="pedido_id" value="<?php echo $pedido['id_pedido']; ?>">
                                <div class="input-group">
                                    <select name="estado_pedido" class="form-select">
                                        <option value="Pendiente" <?php if ($pedido['estado'] == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                                        <option value="Enviado" <?php if ($pedido['estado'] == 'Enviado') echo 'selected'; ?>>Enviado</option>
                                        <option value="Entregado" <?php if ($pedido['estado'] == 'Entregado') echo 'selected'; ?>>Entregado</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm mx-1">Actualizar</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php include("includes/footer.php"); ?>
