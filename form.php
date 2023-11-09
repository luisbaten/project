<?php
session_start();
include_once('includes/dbconnection.php');

if (isset($_POST['submit_request'])) {
  $primerNombre = $_POST['primerNombre'];
  $segundoNombre = $_POST['segundoNombre'];
  $primerApellido = $_POST['primerApellido'];
  $segundoApellido = $_POST['segundoApellido'];
  $dpi = $_POST['dpi'];
  $direccion = $_POST['direccion'];
  $telefono = $_POST['telefono'];
  $descripcion = $_POST['descripcion'];

  // Manejo de imágenes
  $fotos = [];

  if (!empty($_FILES['fotos']['name'][0])) {
    $upload_dir = 'uploads/';
    $fotos_array = $_FILES['fotos'];

    foreach ($fotos_array['name'] as $key => $name) {
      $tmp_name = $fotos_array['tmp_name'][$key];
      $full_path = $upload_dir . $name;
      $fotos[] = $full_path;

      move_uploaded_file($tmp_name, $full_path);
    }
  }
  print_r($fotos);

  $fotos_str = implode(',', $fotos);

  $query = mysqli_query($con, "INSERT INTO send_project (primerNombre, segundoNombre, primerApellido, segundoApellido, dpi, direccion, telefono, fotos, descripcion) VALUES ('$primerNombre', '$segundoNombre', '$primerApellido', '$segundoApellido', '$dpi', '$direccion', '$telefono', '$fotos_str', '$descripcion')");

  if ($query) {
    echo "<script>alert('Solicitud enviada exitosamente');</script>";
  } else {
    echo "<script>alert('Ocurrió un error al enviar la solicitud');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/icons.min.css">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/red-color.css">
  <link rel="stylesheet" href="assets/css/yellow-color.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
  <title>Solicitud de Proyectos</title>
  <style>
    .preview-image {
      width: 200px;
      height: auto;
    }
  </style>
</head>

<body>
  <?php include_once('includes/header.php'); ?> <br>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Solicitud de Proyectos</h2>

    <form onsubmit="return validarDPI()" action="" method="post" enctype="multipart/form-data">

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="primerNombre">Primer Nombre *</label>
          <input type="text" class="form-control" id="primerNombre" name="primerNombre" required>
        </div>
        <div class="form-group col-md-6">
          <label for="segundoNombre">Segundo Nombre</label>
          <input type="text" class="form-control" id="segundoNombre" name="segundoNombre">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="primerApellido">Primer Apellido</label>
          <input type="text" class="form-control" id="primerApellido" name="primerApellido">
        </div>
        <div class="form-group col-md-6">
          <label for="segundoApellido">Segundo Apellido</label>
          <input type="text" class="form-control" id="segundoApellido" name="segundoApellido">
        </div>
      </div>

      <div class="form-group">
        <label for="dpi">DPI *</label>
        <input type="text" class="form-control" id="dpi" name="dpi" required>
      </div>

      <div class="form-group">
        <label for="direccion">Dirección *</label>
        <input type="text" class="form-control" id="direccion" name="direccion" required>
      </div>

      <div class="form-group">
        <label for="telefono">Número de Teléfono *</label>
        <input type="tel" class="form-control" id="telefono" name="telefono" required>
      </div>

      <div class="form-group">
        <label class="control-label">Fotos como evidencia</label>
        <input type="file" class="form-control-file" name="fotos[]" id="fotos" multiple>
        <div id="image-preview"></div>
        <small><i>Presiona "Elegir archivos" y selecciona una o las fotos que deseas agregar en la solicitud</i></small>
      </div>

      <div class="form-group">
        <label for="descripcion">Descripción *</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
      </div>

      <button type="submit" name="submit_request" class="btn btn-success">Enviar Solicitud</button>
    </form>
  </div> <br>

  <?php include_once('includes/footer.php');
  include_once('includes/signin.php');
  include_once('includes/signup.php');
  ?>
  </main><!-- Main Wrapper -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/plugins.js"></script>
  <script src="assets/js/main.js"></script>

  <script>
    function validarDPI() {
      var dpiInput = document.getElementById('dpi');
      var dpiValue = dpiInput.value;

      if (dpiValue.length < 13 || dpiValue.length > 15) {
        alert('El campo DPI debe tener al menos 13 caracteres.');
        return false;
      }
      return true;
    }
  </script>
  <script>
    $(document).ready(function() {
      var imagePaths = [];

      $('#fotos').change(function() {
        previewImages(this);
      });

      function previewImages(input) {
        if (input.files && input.files.length > 0) {
          for (var i = 0; i < input.files.length; i++) {
            var reader = new FileReader();

            reader.onload = function(e) {
              imagePaths.push(e.target.result);

              $('#image-preview').append('<img src="' + e.target.result + '" alt="Preview Image" class="img-thumbnail preview-image">');
            };

            reader.readAsDataURL(input.files[i]);
          }
        }
      }
    });
  </script>
</body>

</html>