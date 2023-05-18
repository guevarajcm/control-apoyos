<?php
  $curp_solicitante = $_POST['curp_solicitante'];
  $curp_receptor = $_POST['curp_receptor'];
  $curp_final = $_POST['curp_final'];

  $conn = new mysqli('localhost', 'root', '', 'ayuntnog');

  if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM apoyos WHERE curp_solicitante = ? OR curp_receptor = ? OR curp_final = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $curp_solicitante, $curp_receptor, $curp_final);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    echo 'exists';
  } else {
    echo 'not_exists';
  }

  $stmt->close();
  $conn->close();
?>
