<?php require_once "config/conexion.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Casa Raymi</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" /> -->
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/estilos.css" rel="stylesheet" />
</head>

<body>
    <a href="#" class="btn-flotante" id="btnCarrito">Carrito <span class="badge bg-success" id="carrito">0</span></a>
    <!-- Navigation-->
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <img src="assets/img/logo1.png" alt="Logo" style="width: 140px;">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive">
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
<!--
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Tienda Online Shuriken Tacna</h1>
            </div>
        </div>
    </header>

                        -->
    <!-- Slider-->
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel"><ol class="carousel-indicators">
        <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></li>
        <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></li></ol>

    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="assets/img/slider4.png" class="d-block w-100" style="height: 500px;" alt="Slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Productos Elaborados para la Comodidad de su Hogar</h5>
                <p>Tenemos variedad en Modelos y Colores!</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/img/slider5.png" class="d-block w-100" style="height: 500px;" alt="Slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Productos para el Hogar!!</h5>
                <p>Visitenos tambien en Nuestra cuenta de Facebook como Casa Raymi!</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/img/slider6.png" class="d-block w-100" style="height: 500px;" alt="Slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Productos para el Hogar!!</h5>
                <p>Tenemos variedad de camas, colcones y tarimas!</p>
            </div>
        </div>
    </div>

        <a href="#" role="button" onclick="prev()" class="btn btn-primary carousel-control-prev" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </a>
    <a href="#" role="button" onclick="next()" class="btn btn-primary carousel-control-next" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
    </a>


    <script>
    function next() {
        $('#carouselExampleCaptions').carousel('next');
    }

    function prev() {
        $('#carouselExampleCaptions').carousel('prev');
    }
</script>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/scripts.js"></script>

    </div>

    <!-- Section-->
    <section id="productos" class="py-5 bg-light">
        <div class="container py-5 mt-5">
            <header class="mb-5"><h1><strong>Nuestros productos:</strong></h1></header>
            <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" category="all">Todo</button>
                </li>
                <?php
                $query = mysqli_query($conexion, "SELECT * FROM categorias");
                while ($data = mysqli_fetch_assoc($query)) { ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-<?php echo $data['id']; ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-<?php echo $data['id']; ?>" type="button" role="tab" aria-controls="pills-<?php echo $data['id']; ?>" aria-selected="false" category="<?php echo $data['categoria']; ?>"><?php echo $data['categoria']; ?></button>
                    </li>
                <?php } ?>
            </ul>
            </div>
            </div>
        </div>
    </section>
    <!-- Section-->
    <!---Productos--->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row" id="resultado">
                </div>
            </div>
        </div>
    </div>


    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                $query = mysqli_query($conexion, "SELECT p.*, c.id AS id_cat, c.categoria FROM productos p INNER JOIN categorias c ON c.id = p.id_categoria");
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <div class="col mb-5 productos" category="<?php echo $data['categoria']; ?>">
                            <div class="card h-100">
                                <!-- Sale badge-->
                                <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem"><?php echo ($data['precio_normal'] > $data['precio_rebajado']) ? 'Oferta' : ''; ?></div>
                                <!-- Product image-->
                                <img class="card-img-top" src="assets/img/<?php echo $data['imagen']; ?>" alt="..." />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder"><?php echo $data['nombre'] ?></h5>
                                        <p><?php echo $data['descripcion']; ?></p>
                                        <!-- Product reviews-->
                                        <div class="d-flex justify-content-center small text-warning mb-2">
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                        </div>
                                        <!-- Product price-->
                                        <span class="text-muted text-decoration-line-through"><?php echo $data['precio_normal'] ?></span>
                                        <?php echo $data['precio_rebajado'] ?>
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto agregar" data-id="<?php echo $data['id']; ?>" href="#">Agregar</a></div>
                                </div>
                            </div>
                        </div>
                <?php  }
                } ?>

            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Derechos reservados para GRUPO 02    TACNA-2024</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/scripts.js"></script>


</body>

</html>