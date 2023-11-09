<?php if (!isset($conn)) {
  include 'db_connect.php';
} ?>
<h1>Nuevo</h1>
<div class="col-lg-12">
  <div class="card card-outline card-primary">
    <div class="card-body">
      <form action="" id="manage-project">

        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Nombre</label>
              <input type="text" class="form-control form-control-sm" name="name" value="<?php echo isset($name) ? $name : '' ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="">Estado</label>
              <select name="status" id="status" class="custom-select custom-select-sm">
                <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Pendiente</option>
                <option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>En espera</option>
                <option value="5" <?php echo isset($status) && $status == 5 ? 'selected' : '' ?>>Confirmado</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Fecha inicio</label>
              <input type="date" class="form-control form-control-sm" autocomplete="off" name="start_date" value="<?php echo isset($start_date) ? date("Y-m-d", strtotime($start_date)) : '' ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Fecha Fin</label>
              <input type="date" class="form-control form-control-sm" autocomplete="off" name="end_date" value="<?php echo isset($end_date) ? date("Y-m-d", strtotime($end_date)) : '' ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <?php if ($_SESSION['login_type'] == 1) : ?>
            <!-- <div class="col-md-6">
							<div class="form-group">
								<label for="" class="control-label">Project Manager</label>
								<select class="form-control form-control-sm select2" name="manager_id">
									<option></option>
									<?php
                  $managers = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 2 order by concat(firstname,' ',lastname) asc ");
                  while ($row = $managers->fetch_assoc()) :
                  ?>
										<option value="<?php echo $row['id'] ?>" <?php echo isset($manager_id) && $manager_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
									<?php endwhile; ?>
								</select>
							</div>
						</div> -->
            <div class="col-md-6">
              <label for="" class="control-label">Imágen</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="images" onchange="displayImg(this,$(this))">
                <label class="custom-file-label" for="customFile">Buscar</label>
              </div>
            </div>
            <div class="form-group d-flex justify-content-center align-items-center">
              <img src="<?php echo isset($images) ? 'assets/uploads/project/' . $images : '' ?>" alt="image" id="cimg" class="img-fluid img-thumbnail ">
            </div>
          <?php else : ?>
            <input type="hidden" name="manager_id" value="<?php echo $_SESSION['login_id'] ?>">
          <?php endif; ?>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Miembros del proyecto</label>
              <select class="form-control form-control-sm select2" multiple="multiple" name="user_ids[]">
                <option></option>
                <?php
                $employees = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 3 order by concat(firstname,' ',lastname) asc ");
                while ($row = $employees->fetch_assoc()) :
                ?>
                  <option value="<?php echo $row['id'] ?>" <?php echo isset($user_ids) && in_array($row['id'], explode(',', $user_ids)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Precio Inversión</label>
              <input type="number" class="form-control form-control-sm" name="price" value="<?php echo isset($price) ? $price : '' ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-10">
            <div class="form-group">
              <label for="" class="control-label">Descripcion</label>
              <textarea name="description" id="" cols="30" rows="10" class="summernote form-control">
						<?php echo isset($description) ? $description : '' ?>
					</textarea>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="card-footer border-top border-info">
      <div class="d-flex w-100 justify-content-center align-items-center">
        <button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-project">Guardar</button>
        <button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=project_list'">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<style>
  img#cimg {
    height: 15vh;
    width: 15vh;
    object-fit: cover;
    border-radius: 100% 100%;
  }
</style>
<script>
  function displayImg(input, _this) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#cimg').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  $('#manage-project').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
      url: 'ajax.php?action=save_project',
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
            location.href = 'index.php?page=project_list'
          }, 2000)
        }
      }
    })
  })
</script>