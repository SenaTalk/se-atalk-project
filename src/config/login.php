<?php

$host = "localhost"; 
$user = "root";
$pass = ""; 
$db_name = "senatalk"; 
$conexion = new mysqli($host,$user,$pass,$db_name);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

$username = $_POST["username"];
$password = $_POST["password"];

// Hash de la contraseña (para mayor seguridad)
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

if(isset($_POST('submit'))){
    $sql = "INSERT INTO usuarios (username, password) VALUES ('$username', '$password')";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            $user_id = $conexion->insert_id; // Obtenemos el ID del usuario registrado
            echo "Registro exitoso. Tu ID de usuario es: " . $user_id;
            }
    
        if ($stmt->affected_rows > 0) {
            echo "Registro exitoso. ¡Inicia sesión ahora!";
        } else {
            echo "Error al registrar el usuario. Inténtalo de nuevo.";
        }
    
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta.";
    }
}



$conexion->close();
?>
