<?php
require_once "config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['action'] == 'realizar_pedido') {
        $array = json_decode($_POST['data'], true);
        $total = $array['total'];
        $id_cliente = $_SESSION['id'];
        $query = mysqli_query($conexion, "INSERT INTO pedidos (id_cliente, total) VALUES ($id_cliente, $total)");
        $id_pedido = mysqli_insert_id($conexion);
        for ($i=0; $i < count($array['datos']); $i++) { 
            $id_producto = $array['datos'][$i]['id'];
            $cantidad = $array['datos'][$i]['cantidad'];
            $precio = $array['datos'][$i]['precio'];
            $query = mysqli_query($conexion, "INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, precio) VALUES ($id_pedido, $id_producto, $cantidad, $precio)");
        }
        $array['id_pedido'] = $id_pedido;
        echo json_encode($array);
        die();
    }
  }

if (isset($_POST)) {
    if ($_POST['action'] == 'buscar') {
        $array['datos'] = array();
        $total = 0;
        for ($i=0; $i < count($_POST['data']); $i++) { 
            $id = $_POST['data'][$i]['id'];
            $query = mysqli_query($conexion, "SELECT * FROM productos WHERE id = $id");
            $result = mysqli_fetch_assoc($query);
            $data['id'] = $result['id'];
            $data['precio'] = $result['precio_rebajado'];
            $data['nombre'] = $result['nombre'];
            $total = $total + $result['precio_rebajado'];
            array_push($array['datos'], $data);
        }
        $array['total'] = $total;
        echo json_encode($array);
        die();
    }
}

?>