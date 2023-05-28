<!-- delete.php -->
<?php
session_start();  // Iniciar sesión

// Conectarse a la base de datos
$conn = new mysqli('localhost', 'root', '', 'ayuntnog');

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id = $_GET['id'];

// eliminar la fila con esta id de la base de datos
$query = "DELETE FROM apoyos WHERE id = $id";

if($conn->query($query) === TRUE){
    // Redirige de vuelta a la página original
    header('Location: apoyos.php');
} else {
    echo "Error al eliminar el registro: " . $conn->error;
}
$conn->close();
?>
