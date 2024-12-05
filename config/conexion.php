<?php
// Leer la URL de conexión desde la variable de entorno
$mysql_url = getenv('MYSQL_URL');

// Validar si la URL está disponible
if ($mysql_url) {
    // Descomponer la URL en partes
    $parts = parse_url($mysql_url);

    // Extraer los datos de conexión
    $host = $parts['host'];               // Host: mysql.railway.internal
    $user = $parts['user'];               // Usuario: root
    $password = $parts['pass'];           // Contraseña: vWfgUwnhMryZlCfcavTynaiRNqdZRIMr
    $db = ltrim($parts['path'], '/');     // Base de datos: railway
    $port = $parts['port'] ?? 3306;       // Puerto: 3306 (por defecto)
} else {
    die("No se encontró la variable de entorno MYSQL_URL");
}

// Establecer la conexión a la base de datos
$conexion = mysqli_connect($host, $user, $password, $db, $port);

// Verificar si hay errores en la conexión
if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Confirmar que la conexión fue exitosa
echo "Conexión exitosa a la base de datos";
?>
