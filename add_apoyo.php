<!-- apoyos.php -->
<?php
session_start();  // Iniciar sesión

// Conectarse a la base de datos
$conn = new mysqli('localhost', 'root', '', 'ayuntnog');

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si el CURP ya existe
$check_query = "SELECT * FROM apoyos WHERE curp_solicitante = ? OR curp_final = ? LIMIT 1";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("ss", $curp_solicitante, $curp_final);
$check_stmt->execute();
$check_stmt->store_result();
if ($check_stmt->num_rows > 0) {
    // El CURP ya existe, redirigir a la página de apoyos con un mensaje de error
    $_SESSION['error'] = "Alguna de las CURP ingresadas ya existe en el sistema.";
    header("Location: apoyos.php");
    exit;
}
$check_stmt->close();


//Obtener usuario autenticado:
$usuario_autenticado = $_SESSION['username'] ?? '';

// Obtener datos del formulario
$curp_solicitante = $_POST['curp_solicitante'];
$nombre_final = $_POST['nombre_final'];
$curp_final = $_POST['curp_final'];
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

// Función para validar el formato de la CURP
function validarCURP($curp) {
    $re = '/^[A-Z]{1}[AEIOU]{1}[A-Z]{2}\d{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}[A-Z]{2}[B-DF-HJ-NP-TV-Z]{3}[A-Z0-9]{1}\d{1}$/i';
    return preg_match($re, strtoupper($curp));
}


// Verificar si el formato de las CURP es válido
if (!validarCURP($curp_solicitante) || !validarCURP($curp_final)) {
    setcookie('error', 'Alguna de las CURP ingresadas no cumple con el formato válido.', time() + 10, "/");
    header("Location: apoyos.php");
    exit;
}




// Preparar la consulta para insertar el nuevo registro
$stmt = $conn->prepare("INSERT INTO apoyos (curp_solicitante, nombre_final, curp_final, direccion, telefono, monto_apoyo, motivo_apoyo, departamento, created_at, categoria) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if($stmt === false) {
    die("Error en la consulta: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("sssssissss", $curp_solicitante, $nombre_final, $curp_final, $direccion, $telefono, $monto_apoyo, $motivo_apoyo, $departamento, $fecha, $categoria);

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
