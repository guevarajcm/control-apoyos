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
  <link rel="stylesheet" href="styles/style2.css">
  <link rel="icon" href="images/favicon.ico" type="image/ico">
  <title>Apoyos otorgados</title>
 </head>
<body>
<main>
  <div class="container">
  <div class="position-fixed top-0 end-0 p-2" style="z-index: 1;">
  <div class="bg-dark d-flex justify-content-end align-items-center">
    <form action="logout.php" method="POST" class="me-2">
      <button type="submit" class="btn btn-logout">Cerrar sesión</button>
    </form>
  </div>
</div>
    <h1 class="text-center mt-5 add-support-module">Apoyos otorgados</h1>
    <div class="row mt-4">
      <div class="col-md-8 offset-md-2">
        <form action="apoyos.php" method="GET" class="d-inline-block" id="searchForm">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Buscar" name="search" id="searchInput" value="<?php echo $search; ?>">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <button type="button" class="btn btn-secondary" id="clearButton">Limpiar</button>
          </div>
        </form>
        <table class="table table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>CURP</th>
              <th>Monto de apoyo</th>
              <th>Motivo de apoyo</th>
              <th>Departamento</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['id'] . "</td>";
              echo "<td>" . $row['nombre'] . "</td>";
              echo "<td>" . $row['curp'] . "</td>";
              echo "<td>" . $row['monto_apoyo'] . "</td>";
              echo "<td>" . $row['motivo_apoyo'] . "</td>";
              echo "<td>" . $row['departamento'] . "</td>";
              echo "<td>" . $row['fecha'] . "</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    

  </div>

  <!-- Modal para agregar apoyo -->
  <div class="add-support-module" id="addApoyoModal" tabindex="-1
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addApoyoModalLabel">Agregar apoyo</h5>
        </div>
        <form action="add_apoyo.php" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre completo</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
              <label for="curp" class="form-label">CURP</label>
              <input type="text" class="form-control" id="curp" name="curp" required>
            </div>
            <div class="mb-3">
              <label for="monto" class="form-label">Monto de apoyo</label>
              <input type="number" class="form-control" id="monto" name="monto" required>
            </div>
            <div class="mb-3">
              <label for="motivo" class="form-label">Motivo de apoyo</label>
              <input type="text" class="form-control" id="motivo" name="motivo" required>
            </div>
            <div class="mb-3">
              <label for="departamento" class="form-label">Departamento</label>
              <input type="text" class="form-control" id="departamento" name="departamento" required>
            </div>
            <div class="mb-3">
              <label for="fecha" class="form-label">Fecha</label>
              <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Agregar apoyo</button>
          </div>
        </form>
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
</body>
</html>