<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Conectarse a la base de datos
  $conn = new mysqli('localhost', 'root', '', 'ayuntnog');

  // Comprobar la conexión
  if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
  }

  // Obtener los datos del formulario
  $user = $_POST['username'];
  $pass = $_POST['password'];

  // Buscar al usuario en la base de datos
  $sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
  $result = $conn->query($sql);

  // Verificar las credenciales
  if ($result->num_rows > 0) {
    $_SESSION['username'] = $user;
    header("Location: apoyos.php");
  } else {
    $error = "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
  }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/1L_dstPt3HV5HzF6GVdgv2Q6ISCOgvG9W6yT7a" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style1.css">
  <link rel="icon" href="images/favicon.ico" type="image/ico">
  <title>Iniciar sesión</title>
</head>
<body>
<main>
  <div class="container wrapper">
    <div class="row">
      <div class="col-md-4 offset-md-4">
        <h1 class="text-center mt-5">Iniciar sesión</h1>

        <?php
        if (isset($error)) {
          echo '<div class="alert alert-danger">' . $error . '</div>';
        }
        ?>

        <form id="login-form" method="POST" action="login.php" class="mt-4">
          <div class="mb-3">
            <label for="username" class="form-label">Nombre de usuario:</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        </form>
      </div>
    </div>
  </div>
  </main>
  <footer>
  <img src="images/Logo-Nogales-Footer.png" alt="Logo Nogales" />
</footer>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBudJ9LtS7c8X2gf+1zvQMVQXQ/2c8tk3EfbhFvAO1X9J4L+" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
</body>
</html>