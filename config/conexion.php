<?php
// Leer la variable de entorno MYSQL_URL
$mysql_url = getenv('MYSQL_URL');

// Si la variable no está configurada, utilizar valores por defecto
if (!$mysql_url) {
    $host = "localhost";
    $user = "root";
    $clave = "";
    $bd = "bd_raymi";
} else {
    // Si la variable MYSQL_URL está configurada, descomponer la URL
    $parts = parse_url($mysql_url);
    $host = $parts['host'];
    $user = $parts['user'];
    $clave = $parts['pass'];
    $bd = ltrim($parts['path'], '/');  // Elimina la barra inicial de la base de datos
}

// Establecer la conexión
$conexion = mysqli_connect($host, $user, $clave, $bd);

if (mysqli_connect_errno()) {
    echo "No se pudo conectar a la base de datos: " . mysqli_connect_error();
    exit();
}

// Seleccionar la base de datos
mysqli_select_db($conexion, $bd) or die("No se encuentra la base de datos");

// Establecer la codificación de caracteres
mysqli_set_charset($conexion, "utf8");
?>
