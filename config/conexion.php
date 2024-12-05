<?php
// Leer la variable de entorno MYSQL_URL para la conexión a la base de datos
$mysql_url = getenv('MYSQL_URL');

// Si la variable no está configurada, utilizar valores por defecto
if (!$mysql_url) {
    $host = "localhost";
    $user = "root";
    $clave = "";
    $bd = "bd_raymi";
    $port = 3306;  // Puerto predeterminado para MySQL local
} else {
    // Si la variable MYSQL_URL está configurada, descomponer la URL
    $parts = parse_url($mysql_url);
    $host = $parts['host'];
    $user = $parts['user'];
    $clave = $parts['pass'];
    $bd = ltrim($parts['path'], '/');  // Elimina la barra inicial de la base de datos
    $port = $parts['port'] ?? 3306;    // Usa el puerto de la URL o 3306 como predeterminado
}

// Establecer la conexión a la base de datos
$conexion = mysqli_connect($host, $user, $clave, $bd, $port);

// Verificar si hay algún error en la conexión
if (mysqli_connect_errno()) {
    echo "No se pudo conectar a la base de datos: " . mysqli_connect_error();
    exit();
}

// Establecer la codificación de caracteres
mysqli_set_charset($conexion, "utf8");

// Confirmar que la conexión fue exitosa
echo "Conexión exitosa a la base de datos";
?>
