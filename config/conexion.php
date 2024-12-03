<?php
// Leer la variable de entorno MYSQL_URL
$mysql_url = getenv('MYSQL_URL');

// Si la variable no está configurada, utilizar valores por defecto
if (!$mysql_url) {
    // Para entorno local
    $host = "localhost";
    $user = "root";
    $clave = "";
    $bd = "bd_raymi";
} else {
    // Si la variable MYSQL_URL está configurada, descomponer la URL
    $parts = parse_url($mysql_url);
    
    // Asegurarse de que las partes esenciales estén presentes
    $host = $parts['host'] ?? 'localhost';  // Si no está presente, usar localhost por defecto
    $user = $parts['user'] ?? 'root';       // Si no está presente, usar 'root'
    $clave = $parts['pass'] ?? '';          // Si no está presente, usar contraseña vacía
    $bd = ltrim($parts['path'], '/');       // Elimina la barra inicial de la base de datos
    $port = $parts['port'] ?? 3306;         // Si no está presente, usar el puerto 3306 por defecto
}

// Establecer la conexión
$conexion = mysqli_connect($host, $user, $clave, $bd, $port);

// Comprobar si la conexión fue exitosa
if (mysqli_connect_errno()) {
    echo "No se pudo conectar a la base de datos: " . mysqli_connect_error();
    exit();
}

// Establecer la codificación de caracteres
mysqli_set_charset($conexion, "utf8");
?>
