<?php
$host = 'localhost'; // O tu servidor de base de datos
$username = 'root';  // Tu usuario de base de datos (por defecto es 'root' en XAMPP)
$password = '';      // Tu contraseña de base de datos (por defecto está vacía en XAMPP)
$dbname = 'chattrixx'; // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
