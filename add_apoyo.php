<?php

// Conectarse a la base de datos
$conn = new mysqli('localhost', 'root', '', 'ayuntnog');

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$curp = $_POST['curp'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$monto_apoyo = $_POST['monto_apoyo'];
$motivo_apoyo = $_POST['motivo_apoyo'];
$departamento = $_POST['departamento'];
$fecha = $_POST['fecha'];
$categoria = $_POST['categoria'];

// Validar el número de teléfono
if (strlen($telefono) != 10) {
    setcookie('error', 'El número de teléfono debe contener 10 dígitos.', time() + 10, "/");
    header("Location: apoyos.php");
    exit;
}

// Verificar si la CURP ya está registrada
$check_curp = "SELECT * FROM apoyos WHERE curp = '$curp'";
$result = $conn->query($check_curp);

if ($result->num_rows > 0) {
    setcookie('error', 'La CURP ingresada ya está registrada.', time() + 10, "/");
    header("Location: apoyos.php");
    exit;
}

// Preparar y ejecutar la consulta para insertar el apoyo
$stmt = $conn->prepare("INSERT INTO apoyos (nombre, curp, direccion, telefono, monto_apoyo, motivo_apoyo, departamento, fecha, categoria) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssdssss", $nombre, $curp, $direccion, $telefono, $monto_apoyo, $motivo_apoyo, $departamento, $fecha, $categoria);

if ($stmt->execute()) {
    setcookie('success', 'El apoyo se ha agregado correctamente.', time() + 10, "/");
} else {
    setcookie('error', 'Error al agregar el apoyo. Por favor, inténtalo de nuevo.', time() + 10, "/");
}

// Cerrar la conexión
$stmt->close();
$conn->close();

// Redireccionar a la página de apoyos
header("Location: apoyos.php");

?>
