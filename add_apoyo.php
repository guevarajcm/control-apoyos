<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

// Conectarse a la base de datos
$conn = new mysqli('localhost', 'root', '', 'ayuntnog');

// Comprobar la conexión
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// Recuperar los datos del formulario
$nombre = $_POST['nombre'];
$curp = $_POST['curp'];
$monto = $_POST['monto'];
$motivo = $_POST['motivo'];
$departamento = $_POST['departamento'];
$fecha = $_POST['fecha'];

// Preparar la consulta SQL
$sql = "INSERT INTO apoyos (nombre, curp, monto_apoyo, motivo_apoyo, departamento, fecha) VALUES ('$nombre', '$curp', $monto, '$motivo', '$departamento', '$fecha')";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
  header("Location: success.php");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
