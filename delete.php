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



  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // eliminar la fila con esta id de la base de datos
    $query = "DELETE FROM apoyos WHERE id = $id";
    $conn->query($query);

    // Redirige de vuelta a la página original
    header('Location: apoyos.php');
  } else {
    // mostrar una confirmación antes de la eliminación
    echo "¿Estás seguro de que quieres eliminar esta fila?";
    echo "<form method='POST'><button type='submit'>Sí, eliminar</button></form>";
  }
?>
