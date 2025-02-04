<?php
include 'db.php'; // Incluir la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $username = $_POST['register-username'];
    $password = $_POST['register-password'];
    $password_repeat = $_POST['register-password-repeat'];


    // Validación de todos los campos
    if (empty($username) || empty($password) || empty($password_repeat)) {
        echo "Por favor completa todos los campos.";
        exit();
    }

    // Verificar que las contraseñas coinciden
    if ($password !== $password_repeat) {
        echo "Las contraseñas no coinciden.";
        exit();
    }

    // Verificar si el usuario ya exite
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Este usuario ya existe.";
        $stmt->close();
        exit();
    }

    // Encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta para evitar injecciones
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password); // ss significa que son cadenas de texto

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Usuario registrado correctamente.";
    } else {
        echo "Error al registrarse: " . $stmt->error;
    }

    // Cerrar la sentencia preparada 
    $stmt->close();

}
?>

<!-- Formulario de registro -->
<form action="register.php" method="POST">
    <label for="register-username">Correo electrónico o usuario</label>
    <input type="text" name="register-username" id="register-username" placeholder="Correo electrónico o usuario" required>

    <label for="register-password">Contraseña</label>
    <input type="password" name="register-password" id="register-password" placeholder="Contraseña" required>

    <label for="register-password-repeat">Repite tu contraseña</label>
    <input type="password" name="register-password-repeat" id="register-password-repeat" placeholder="Repite tu contraseña" required>

    <button type="submit">Registrarse</button>
</form>
