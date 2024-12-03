<?php 
require_once "config/conexion.php";
require_once "config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["realizar_pedido"])) {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo_electronico = $_POST["correo_electronico"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $tipo_pago = $_POST["tipo_pago"];
    $total_pagar = $_POST["total_pagar"];

    $query = "INSERT INTO pedidos (nombre, apellido, correo_electronico, telefono, direccion, tipo_pago, total_pagar) VALUES ('$nombre', '$apellido', '$correo_electronico', '$telefono', '$direccion', '$tipo_pago', '$total_pagar')";
    $result = mysqli_query($conexion, $query);
    if (!$result) {
        die(mysqli_error($conexion));
    }
    $id_pedido = mysqli_insert_id($conexion);
    if (isset($_SESSION['id'])) {
        $id_cliente = $_SESSION['id'];
        $query = "INSERT INTO pedidos_clientes (id_pedido, id_cliente) VALUES ('$id_pedido', '$id_cliente')";
        $result = mysqli_query($conexion, $query);
        if (!$result) {
            die(mysqli_error($conexion));
        }
    }
    if (isset($_SESSION['carrito'])) {
        $carrito = $_SESSION['carrito'];
        // Preparamos la consulta
        $query = "INSERT INTO pedidos_productos (id_pedido, id_producto, cantidad) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $query);
    
        if ($stmt === false) {
            die(mysqli_error($conexion));
        }
    
        // Vinculamos los parámetros
        mysqli_stmt_bind_param($stmt, 'iii', $id_pedido, $id_producto, $cantidad);
    
        foreach ($carrito as $producto) {
            $id_producto = $producto['id'];
            $cantidad = $producto['cantidad'];
    
            // Ejecutamos la consulta para cada producto
            if (!mysqli_stmt_execute($stmt)) {
                die(mysqli_error($conexion));
            }
        }
    
        // Cerramos la sentencia preparada
        mysqli_stmt_close($stmt);
    }
    
    unset($_SESSION['carrito']);
    header("Location: index.php");
    exit;
    
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Realizar pedido</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" /> -->
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/estilos.css" rel="stylesheet" />

</head>

<body>
<!-- Navigation-->
<div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <img src="assets/img/logo1.png" alt="Logo" style="width: 140px;">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                    <ul class="navbar-nav ml-auto align-items-center mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Inicio</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="nosotros.php">Nosotros</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="productos.php">Productos</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="carrito.php">Carrito</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="admin/index.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contactenos.php">
                                <button style="background-color: #ff9900; color: #ffffff; border: none; padding: 10px 20px; border-radius: 5px; font-size: 16px; font-weight: bold;">
                                    Contáctenos
                                </button>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Carrito</h1>
                <p class="lead fw-normal text-white-50 mb-0">Tus Productos Agregados.</p>
            </div>
        </div>
    </header>
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            <tbody id="tblCarrito">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-5 ms-auto">
                    <h4>Total a Pagar: <span id="total_pagar">0.00</span></h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Formulario para realizar el pedido -->

    <!-- Agrega el formulario para realizar el pedido -->
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea class="form-control" id="direccion" name="direccion" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tipo_pago" class="form-label">Tipo de Pago</label>
                            <select class="form-control" id="tipo_pago" name="tipo_pago" required>
                                <option value="1">Pago con YAPE O PLIN</option>
                                <option value="2">Pago vía TRANSFERENCIA BANCARIA</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <input type="hidden" id="total_pagar_input" name="total_pagar">
                            <button class="btn btn-success" type="submit" name="realizar_pedido" id="btnRealizarPedido">Realizar Pedido</button>
                            <button class="btn btn-danger" type="button" id="btnVaciar">Vaciar Carrito</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Derechos reservados para GRUPO 12 3ER AÑO ESIS 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&locale=<?php echo LOCALE; ?>"></script>
    <script src="assets/js/scripts.js"></script>
    <script>

document.addEventListener("DOMContentLoaded", function () {
    // Mostrar carrito al cargar
    mostrarCarrito();

    // Actualizar el total_pagar_input antes de enviar el formulario
    const formularioPedido = document.querySelector("form");
    formularioPedido.addEventListener("submit", function (event) {
        const totalPagar = document.querySelector("#total_pagar").innerText;
        document.querySelector("#total_pagar_input").value = totalPagar;
    });
});

        function mostrarCarrito() {
            if (localStorage.getItem("productos") != null) {
                let array = JSON.parse(localStorage.getItem('productos'));
                if (array.length > 0) {
                    $.ajax({
                        url: 'ajax.php',
                        type: 'POST',
                        async: true,
                        data: {
                            action: 'buscar',
                            data: array
                        },
                        success: function(response) {
                            console.log(response);
                            const res = JSON.parse(response);
                            let html = '';
                            res.datos.forEach(element => {
                                html += `
                            <tr>
                                <td>${element.id}</td>
                                <td>${element.nombre}</td>
                                <td>${element.precio}</td>
                                <td>1</td>
                                <td>${element.precio}</td>
                            </tr>
                            `;
                            });
                            $('#tblCarrito').html(html);
                            $('#total_pagar').text(res.total);
                            paypal.Buttons({
                                style: {
                                    color: 'blue',
                                    shape: 'pill',
                                    label: 'pay'
                                },
                                createOrder: function(data, actions) {
                                    return actions.order.create({
                                        purchase_units: [{
                                            amount: {
                                                value: res.total
                                            }
                                        }]
                                    });
                                },
                                onApprove: function(data, actions) {
                                    return actions.order.capture().then(function(details) {
                                        alert('Transaction completed by ' + details.payer.name.given_name);
                                    });
                                }
                            }).render('#paypal-button-container');
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            }
            
        }
        
        
        
    </script>
</body>

</html>