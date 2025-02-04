<?php 
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenemos los datos del formulario.
    $username = $_POST['username'];
    $password = $_POST['password'];


    // Validadar si los campos estan vacíos.
    if (empty($username) || empty($password)) {
        echo "Por favor completa todos los campos.";
        exit();
    }


    // Verificar si existe el usuario.
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Verificar contraseña al saber que el usuario exite.
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Verificar si es correcta la contraseña
        if (password_verify($password, $hashed_password)) {
            // Iniciar sesión.
            session_start();
            $_SESSION['user_id'] = $id;
            echo "Inicio exitoso.";
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
    $stmt->close();
}
?>