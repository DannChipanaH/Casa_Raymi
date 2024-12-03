<?php
require_once "../config/conexion.php";

// Verificar si se recibió el parámetro "id" en la URL
if (isset($_GET['id'])) {
    // Obtener el ID del producto desde la URL
    $id_producto = $_GET['id'];

    // Verificar si se enviaron los datos del formulario por el método POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $p_normal = $_POST['p_normal'];
        $p_rebajado = $_POST['p_rebajado'];
        $cantidad = $_POST['cantidad'];
        $categoria = $_POST['categoria'];
        $img = $_FILES['foto'];
        $name = $img['name'];
        $tmpname = $img['tmp_name'];
        $fecha = date("YmdHis");
        $foto = $fecha . ".jpg";
        $destino = "../assets/img/" . $foto;

        // Verificar si se subió una imagen
        if ($name != '') {
            // Actualizar los datos del producto en la base de datos
            $query = mysqli_query($conexion, "UPDATE productos SET nombre = '$nombre', descripcion = '$descripcion', precio_normal = '$p_normal', precio_rebajado = '$p_rebajado', cantidad = $cantidad, imagen = '$foto', id_categoria = $categoria WHERE id = $id_producto");
            if ($query) {
                // Mover la imagen a la carpeta "assets/img"
                if (move_uploaded_file($tmpname, $destino)) {
                    header('Location: productos.php');
                }
            }
        } else {
            // Actualizar los datos del producto en la base de datos
            $query = mysqli_query($conexion, "UPDATE productos SET nombre = '$nombre', descripcion = '$descripcion', precio_normal = '$p_normal', precio_rebajado = '$p_rebajado', cantidad = $cantidad, id_categoria = $categoria WHERE id = $id_producto");
            if ($query) {
                header('Location: productos.php');
            }
        }
    }
    try{
        // Obtener los datos del producto desde la base de datos
        $query = mysqli_query($conexion, "SELECT * FROM productos WHERE id = $id_producto");
        $data = mysqli_fetch_assoc($query);
    }catch(Exception $e){
        echo $e->getMessage();
    }
}
include("includes/header.php"); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo isset($id_producto) ? 'Editar' : 'Nuevo'; ?> Producto</h1>
    <a href="productos.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Regresar</a>
</div>

<div class="row">
    <div class="col-md-12">
        <form method="post" action="<?php echo isset($id_producto) ? "editar_producto.php?id=$id_producto" : 'editar_producto.php'; ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre del producto</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo isset($data) ? $data['nombre'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción del producto</label>
                <textarea name="descripcion" id="descripcion" class="form-control"><?php echo isset($data) ? $data['descripcion'] : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="p_normal">Precio normal</label>
                <input type="number" name="p_normal" id="p_normal" class="form-control" value="<?php echo isset($data) ? $data['precio_normal'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="p_rebajado">Precio rebajado</label>
                <input type="number" name="p_rebajado" id="p_rebajado" class="form-control" value="<?php echo isset($data) ? $data['precio_rebajado'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" value="<?php echo isset($data) ? $data['cantidad'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="categoria">Categoría</label>
                <select name="categoria" id="categoria" class="form-control">
                    <?php
                    $query = mysqli_query($conexion, "SELECT * FROM categorias");
                    while ($data_cat = mysqli_fetch_assoc($query)) { ?>
                        <option value="<?php echo $data_cat['id']; ?>" <?php echo isset($data) && $data['id_categoria'] == $data_cat['id'] ? 'selected' : ''; ?>><?php echo $data_cat['categoria']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="foto">Imagen</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit"><?php echo isset($id_producto) ? 'Editar' : 'Agregar'; ?> Producto</button>
            </div>
        </form>
    </div>
</div>

<?php include("includes/footer.php"); ?>

<script>
    $(document).ready(function() {
        $('#abrirProducto').click(function() {
            $('#producto').modal('show');
        });
    });
</script>
