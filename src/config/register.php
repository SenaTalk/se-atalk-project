<?php
$conexion = new mysqli("servidor", "usuario", "contrasena", "basededatos");

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

$username = $_POST["username"];
$email = $_POST["gmail"];
$password = $_POST["password"];

// Hash de la contraseña (para mayor seguridad)
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO usuarios (username, email, password) VALUES ('$username', '$email', '$password)";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script> alert= (Registro exitoso. ¡Inicia sesión ahora!)";
    } else {
        echo "Error al registrar el usuario. Inténtalo de nuevo.";
    }

    $stmt->close();
} else {
    echo "Error en la preparación de la consulta.";
}

$conexion->close();
?>
