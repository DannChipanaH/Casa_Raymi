<?php
// La URL de conexión proporcionada por Railway
$mysql_url = "mysql://root:vWfgUwnhMryZlCfcavTynaiRNqdZRIMr@autorack.proxy.rlwy.net:39272/railway";

// Descomponer la URL en partes usando parse_url
$parts = parse_url($mysql_url);

// Extraer los datos de conexión
$host = $parts['host'];           // autorack.proxy.rlwy.net
$user = $parts['user'];           // root
$password = $parts['pass'];       // Contraseña que tienes en la URL
$db = ltrim($parts['path'], '/'); // railway (nombre de la base de datos)
$port = $parts['port'];           // 39272

// Establecer la conexión a la base de datos
$conexion = mysqli_connect($host, $user, $password, $db, $port);

// Verificar si hay errores en la conexión
if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

?>
