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

$search = '';
if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $sql = "SELECT * FROM apoyos WHERE nombre LIKE '%$search%' OR curp LIKE '%$search%' OR motivo_apoyo LIKE '%$search%' OR departamento LIKE '%$search%'";
} else {
  $sql = "SELECT * FROM apoyos";
}

$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/1L_dstPt3HV5HzF6GVdgv2Q6ISCOgvG9W6yT7a" crossorigin="anonymous">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="styles/style2.css">
  <link rel="icon" href="images/favicon.ico" type="image/ico">
  <title>Apoyos otorgados</title>
 </head>
<body>
<main>
  <div>
<div class="logout-button-wrapper">
  <form action="logout.php" method="POST" class="me-2">
  <button type="submit" class="btn btn-logout">Cerrar sesión</button>
  </form>
   <!-- Modal para agregar apoyo -->
 <div class="modal fade" id="addApoyoModal" tabindex="-1" aria-labelledby="addApoyoModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addApoyoModalLabel">Agregar apoyo</h5>
          </div>
          <form action="add_apoyo.php" method="POST">
            <div class="modal-body">
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
              </div>
              <div class="mb-3">
                <label for="curp" class="form-label">CURP</label>
                <input type="text" class="form-control" id="curp" name="curp" required>
              </div>
              <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
              </div>
              <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" pattern="\d{10}" required>
              </div>
              <div class="mb-3">
                <label for="monto_apoyo" class="form-label">Monto de Apoyo</label>
                <input type="number" class="form-control" id="monto_apoyo" name="monto_apoyo" required>
              </div>
              <div class="mb-3">
                <label for="motivo_apoyo" class="form-label">Motivo de Apoyo</label>
                <input type="text" class="form-control" id="motivo_apoyo" name="motivo_apoyo" required>
              </div>
              <div class="mb-3">
                <label for="departamento" class="form-label">Departamento</label>
                <input type="text" class="form-control" id="departamento" name="departamento" required>
              </div>
              <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
              </div>
              <div class="mb-3">
              <label for="categoria" class="form-label">Categoría</label>
                <input type="text" class="form-control" id="categoria" name="categoria" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-success">Agregar apoyo</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>


  <!-- JavaScript para mostrar el modal de agregar apoyo -->
  <script>
    var myModal = document.getElementById('addApoyoModal');
    myModal.addEventListener('shown.bs.modal', function () {
      document.getElementById('nombre').focus();
    });
  </script>
  </div>
  <div class="container">
  <div class="position-fixed bg-light p-3" style="z-index: 1;">
  <div class="bg-dark d-flex justify-content-end align-items-center">
  </div>
</div>
    <h1 class="text-center mt-5 add-support-module">Apoyos otorgados</h1>
    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success text-center" role="alert">
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

    <div class="row mt-4">
      <div class="col-md-8 offset-md-2">
        <form action="apoyos.php" method="GET" class="d-inline-block" id="searchForm">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Buscar" name="search" id="searchInput" value="<?php echo $search; ?>">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <button type="button" class="btn btn-secondary" id="clearButton">Limpiar</button>
          </div>
        </form>
        
<div class="table-wrapper">
  <table class="table table-striped">
    <thead>
    <tr class="table-scroll">
        <th style="width: 50px;">ID</th>
        <th>Nombre</th>
        <th>CURP</th>
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Monto de Apoyo</th>
        <th>Motivo de apoyo</th>
        <th>Departamento</th>
        <th>Fecha de creación</th>
        <th>Categoría</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nombre'] . "</td>";
        echo "<td>" . $row['curp'] . "</td>";
        echo "<td>" . $row['direccion'] . "</td>";
        echo "<td>" . $row['telefono'] . "</td>";
        echo "<td>" . $row['monto_apoyo'] . "</td>";
        echo "<td>" . $row['motivo_apoyo'] . "</td>";
        echo "<td>" . $row['departamento'] . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "<td>" . $row['categoria'] . "</td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</div>



      </div>
    </div>
  </div>


  
  <!-- Scripts de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-yzGdBNOg6N84CyYUgKjyLp6F/dV9UBTJpItmV7AuZjIWb2m7wMkpik89yV7MjCg+" crossorigin="anonymous"></script>
  <script>
  document.getElementById('clearButton').addEventListener('click', function() {
    document.getElementById('searchInput').value = '';
    document.getElementById('searchForm').submit();
  });
</script>
  </main>
  <footer>
  <img src="images/Logo-Nogales-Footer.png" alt="Logo Nogales" />
</footer>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const currentDate = `${year}-${month}-${day}`;

    const fechaInput = document.getElementById("fecha");
    fechaInput.setAttribute("min", currentDate);
    fechaInput.setAttribute("max", currentDate);
    fechaInput.value = currentDate;
  });
</script>
<script>
 // Mostrar alerta de error
if (getCookie("error")) {
  const decodedError = decodeURIComponent(getCookie("error"));
  Swal.fire({
    icon: "error",
    title: "Error",
    text: decodedError,
    timer: 5000,
    showConfirmButton: false,
  });
  document.cookie = "error=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

  // Mostrar alerta de éxito
if (getCookie("success")) {
  const successMessage = decodeURIComponent(getCookie("success"));
  Swal.fire({
    icon: "success",
    title: "Éxito",
    text: successMessage,
    timer: 5000,
    showConfirmButton: false,
  });
  document.cookie = "success=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}


  // Función para obtener el valor de una cookie
  function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(";").shift();
  }
</script>
<script>
  // Mostrar alerta de error
  if (getCookie("error")) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: getCookie("error"),
      timer: 5000,
      showConfirmButton: false,
    });
    document.cookie = "error=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  }

  // Mostrar alerta de éxito
  if (getCookie("success")) {
    Swal.fire({
      icon: "success",
      title: "Éxito",
      text: getCookie("success"),
      timer: 5000,
      showConfirmButton: false,
    });
    document.cookie = "success=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  }

  // Función para obtener el valor de una cookie
  function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(";").shift();
  }
</script>

<script>
  // Función para tomar fecha de pc
  document.addEventListener("DOMContentLoaded", function() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const currentDate = `${year}-${month}-${day}`;

    const fechaInput = document.getElementById("fecha");
    fechaInput.setAttribute("min", currentDate);
    fechaInput.setAttribute("max", currentDate);
    fechaInput.value = currentDate;
  });
</script>
</body>
</html>
