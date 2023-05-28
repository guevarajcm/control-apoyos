<!-- edit.php -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Editar Apoyo</title>
  <link rel="stylesheet" href="styles/style3.css">
</head>
<body>
  <div class="container">

<?php
session_start();  // Iniciar sesión

// Conectarse a la base de datos
$conn = new mysqli('localhost', 'root', '', 'ayuntnog');

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id = $_GET['id'];  // obtener la id desde la URL

// Obtener los detalles de la fila específica
$query = "SELECT * FROM apoyos WHERE id = $id";
$result = $conn->query($query);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // actualizar los datos de la fila
  $curp_solicitante = $_POST['curp_solicitante'];
  $curp_receptor = $_POST['curp_receptor'];
  $curp_final = $_POST['curp_final'];
  $direccion = $_POST['direccion'];
  $telefono = $_POST['telefono'];
  $monto_apoyo = $_POST['monto_apoyo'];
  $motivo_apoyo = $_POST['motivo_apoyo'];
  $departamento = $_POST['departamento'];
  $categoria = $_POST['categoria'];
  $created_at = $_POST['created_at'];

  $query = "UPDATE apoyos SET curp_solicitante='$curp_solicitante', curp_receptor='$curp_receptor', 
  curp_final='$curp_final', direccion='$direccion', telefono='$telefono', 
  monto_apoyo='$monto_apoyo', motivo_apoyo='$motivo_apoyo', departamento='$departamento', 
  categoria='$categoria', created_at='$created_at' WHERE id=$id";
  
  $conn->query($query);

  // Redirige de vuelta a la página original
  header('Location: apoyos.php');
} else {
  // Mostrar el formulario de edición
  ?>
  <form method="POST">
    CURP Solicitante: <input type="text" name="curp_solicitante" value="<?php echo $row['curp_solicitante']; ?>"><br>
    CURP Receptor: <input type="text" name="curp_receptor" value="<?php echo $row['curp_receptor']; ?>"><br>
    CURP Final: <input type="text" name="curp_final" value="<?php echo $row['curp_final']; ?>"><br>
    Dirección: <input type="text" name="direccion" value="<?php echo $row['direccion']; ?>"><br>
    Teléfono: <input type="text" name="telefono" value="<?php echo $row['telefono']; ?>"><br>
    Monto de Apoyo: <input type="text" name="monto_apoyo" value="<?php echo $row['monto_apoyo']; ?>"><br>
    Motivo de apoyo: <input type="text" name="motivo_apoyo" value="<?php echo $row['motivo_apoyo']; ?>"><br>
    Departamento: <input type="text" name="departamento" value="<?php echo $row['departamento']; ?>"><br>
    Categoría: <input type="text" name="categoria" value="<?php echo $row['categoria']; ?>"><br>
    Fecha de Creación: <input type="datetime-local" name="created_at" value="<?php echo $row['created_at']; ?>"><br>
    <div class="button-container">
        <button type="submit">Guardar</button>&nbsp;&nbsp;&nbsp;
        <button type="button" onclick="location.href='apoyos.php';">Cancelar</button>
      </div>
  </form>
</div>
  <?php
}
?>

</body>
<footer>
    <img src="images/Logo-Nogales-Footer.png" alt="Logo Nogales" />
  </footer>
</html>