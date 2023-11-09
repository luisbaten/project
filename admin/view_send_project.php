<?php
echo "ID del registro: " . $_GET['id'];
$id = $_GET['id'];

$i = 1;
$qry = $conn->query("SELECT * FROM send_project WHERE id = $id ORDER BY id DESC");

if (!$qry) {
  printf("Error en la consulta: %s\n", $conn->error);
} else {
  $num_rows = $qry->num_rows;
  echo "Número de filas devueltas: " . $num_rows;

  if ($num_rows > 0) {
    $row = $qry->fetch_assoc();
?>
    <div class="col-lg-12">
      <div class="row">
        <div class="col-md-12">
          <div class="callout callout-info">
            <div class="col-md-12">
              <div class="row">
                <!-- Agregar más detalles según sea necesario -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-primary">
            <div class="card-header">
              <span><b>Detalles de la Solicitud:</b></span>
            </div>
            <div class="card-body">
              <dl class="row">
                <div class="col-md-6">
                  <dt class="col-sm-6"><b class="border-bottom border-primary">Primer Nombre</b></dt>
                  <dd style="color:black" class="col-sm-6"><?php echo $row['primerNombre'] ?></dd>

                  <dt class="col-sm-6"><b class="border-bottom border-primary">Segundo Nombre</b></dt>
                  <dd style="color:black" class="col-sm-6"><?php echo $row['segundoNombre'] ?></dd>

                  <dt class="col-sm-6"><b class="border-bottom border-primary">Primer Apellido</b></dt>
                  <dd style="color:black" class="col-sm-6"><?php echo $row['primerApellido'] ?></dd>

                  <dt class="col-sm-6"><b class="border-bottom border-primary">Segundo Apellido</b></dt>
                  <dd style="color:black" class="col-sm-6"><?php echo $row['segundoApellido'] ?></dd>

                  <dt class="col-sm-6"><b class="border-bottom border-primary">Descripcion</b></dt>
                  <dd style="color:black" class="col-sm-6"><?php echo $row['descripcion'] ?></dd>

                </div>

                <div class="col-md-6">
                  <dt class="col-sm-6"><b class="border-bottom border-primary">Estado</b></dt>
                  <dd class="col-sm-6">
                    <?php
                    $status_labels = array("Pendiente", "Aceptada", "Rechazada");
                    echo "<span class='badge badge-" . ($row['status'] == 1 ? "secondary" : ($row['status'] == 2 ? "success" : "danger")) . "'>" . $status_labels[$row['status']] . "</span>";
                    ?>
                  </dd>

                  <dt class="col-sm-6"><b class="border-bottom border-primary">Teléfono</b></dt>
                  <dd style="color:black" class="col-sm-6"><?php echo $row['telefono'] ?></dd>

                  <dt class="col-sm-6"><b class="border-bottom border-primary">Dirección</b></dt>
                  <dd style="color:black" class="col-sm-6"><?php echo $row['direccion'] ?></dd>

                  <dt class="col-sm-6"><b class="border-bottom border-primary">DPI</b></dt>
                  <dd style="color:black" class="col-sm-6"><?php echo $row['dpi'] ?></dd>
                </div>
              </dl>

              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <b>Imágenes Adjuntas</b>
                    </div>
                    <div class="card-body">
                      <?php
                      $fotos_array = explode(',', $row['fotos']);
                      foreach ($fotos_array as $foto) {
                        echo "<img src='../$foto' class='img-thumbnail' alt='Imagen' style='width: 200px;'>";
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php
  } else {
    echo "No se encontraron resultados para el ID proporcionado.";
  }
}
?>