<?php
// Parámetros de conexión
$servidor = "localhost";
$usuario = "root"; // Cambia esto si tu usuario de MySQL es diferente
$contrasena = "";  // Coloca la contraseña de tu MySQL si tiene
$bd = "registro_usuarios";

// Crear conexión
$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST["nombre"] ?? '';
$apellido = $_POST["apellido"] ?? '';
$correo = $_POST["correo"] ?? '';
$clave = $_POST["clave"] ?? '';

// Validar campos
if (empty($nombre) || empty($apellido) || empty($correo) || empty($clave)) {
    echo "Por favor, completa todos los campos.";
    exit;
}

// Encriptar la contraseña
$clave_hash = password_hash($clave, PASSWORD_DEFAULT);

// Preparar la consulta SQL para insertar datos
$sql = "INSERT INTO usuarios (nombre, apellido, correo, clave) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nombre, $apellido, $correo, $clave_hash);

// Ejecutar e informar al usuario
if ($stmt->execute()) {
    echo "Registro exitoso. <a href='../register.html'>Volver</a>";
} else {
    echo "Error al registrar: " . $stmt->error;
}

// Cerrar conexiones
$stmt->close();
$conn->close();
?>
