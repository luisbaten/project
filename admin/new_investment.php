<?php
$isEditing = isset($id);
?>
<h1><?php echo $isEditing ? 'Editando Inversión' : 'Nueva Inversión'; ?></h1>
<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <form action="" id="manage_investment">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
        <div class="row">
          <div class="col-md-6 border-right">
            <div class="form-group">
              <label for="" class="control-label">Proyecto</label>
              <select name="project_id" class="form-control form-control-sm" required>
                <?php
                $projects = $conn->query("SELECT id, name FROM project_list");

                foreach ($projects as $project) {
                  echo "<option value='{$project['id']}'>{$project['name']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="" class="control-label">Monto de Inversión</label>
              <input type="number" name="amount" class="form-control form-control-sm" required value="<?php echo isset($amount) ? $amount : ''; ?>">
            </div>
            <div class="form-group">
              <label for="" class="control-label">Descripción</label>
              <textarea name="description" class="form-control form-control-sm" required><?php echo isset($description) ? $description : ''; ?></textarea>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Fecha de Realización del Gasto</label>
              <input type="date" name="expense_date" class="form-control form-control-sm" required>
            </div>
            <div class="form-group">
              <label for="" class="control-label"> Imagen</label>
              <input type="file" name="imagen" class="form-control-file">
            </div>
          </div>
        </div>
        <hr>
        <div class="col-lg-12 text-right justify-content-center d-flex">
          <button class="btn btn-primary mr-2" form="manage_investment">Guardar</button>
          <button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=inversion_list'">Cancelar</button>
        </div>
      </form>

    </div>
  </div>
</div>
<script>
  $('#manage_investment').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
      url: 'ajax.php?action=save_investment',
      data: new FormData($(this)[0]),
      cache: false,
      contentType: false,
      processData: false,
      method: 'POST',
      type: 'POST',
      success: function(resp) {
        if (resp == 1) {
          alert_toast('Data successfully saved', "success");
          setTimeout(function() {
            location.href = 'index.php?page=inversion_list'
          }, 2000)
        }
      }
    })
  })
</script>