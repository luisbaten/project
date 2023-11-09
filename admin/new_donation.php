<?php if (!isset($conn)) {
  include 'db_connect.php';
} ?>
<h1>Editar Donación</h1>
<div class="col-lg-12">
  <div class="card card-outline card-primary">
    <div class="card-body">
      <form action="" id="edit-donation">

        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Cliente</label>
              <select name="client_id" class="form-control form-control-sm" required>
                <option value="">Seleccionar Cliente</option>
                <?php
                $clients = $conn->query("SELECT * FROM clients");
                while ($row = $clients->fetch_assoc()) :
                ?>
                  <option value="<?php echo $row['id'] ?>" <?php echo isset($client_id) && $client_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['firstname'] . ' ' . $row['lastname'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Proyecto</label>
              <select name="project_list_id" class="form-control form-control-sm" required>
                <option value="">Seleccionar Proyecto</option>
                <?php
                $projects = $conn->query("SELECT * FROM project_list");
                while ($row = $projects->fetch_assoc()) :
                ?>
                  <option value="<?php echo $row['id'] ?>" <?php echo isset($project_list_id) && $project_list_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Monto de Donación</label>
              <input type="text" class="form-control form-control-sm" name="donation_amount" value="<?php echo isset($donation_amount) ? $donation_amount : '' ?>" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Fecha de Donación</label>
              <input type="date" class="form-control form-control-sm" name="date_created" value="<?php echo isset($approval_date) ? date("Y-m-d", strtotime($approval_date)) : '' ?>" required>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="card-footer border-top border-primary">
      <div class="d-flex w-100 justify-content-center align-items-center">
        <button class="btn btn-flat  bg-gradient-primary mx-2" form="edit-donation">Guardar</button>
        <button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=donation_list'">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<script>
  $('#edit-donation').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
      url: 'ajax.php?action=save_donation',
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
            location.href = 'index.php?page=donation_list'
          }, 2000)
        }
      }
    })
  })
</script>