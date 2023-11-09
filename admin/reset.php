<?php if (!isset($conn)) {
  include 'db_connect.php';
} ?>
<style>
  textarea {
    resize: none;
  }
</style>
<?php include 'header.php' ?>
<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-4">
      <form id="manage">
        <div class="form-group">
          <input type="email" class="form-control" id="email" placeholder="Correo Electrónico" required>
        </div>
        <div class="form-group">
          <label for="generatedPassword">Contraseña Generada:</label>
          <input type="text" class="form-control" id="generatedPassword" readonly>
          <small id="passwordHelp" class="form-text text-muted">Haz clic en "Generar Contraseña" para obtener una nueva.</small>
          <button type="button" class="btn btn-secondary mt-2" onclick="generatePassword()">Generar Contraseña</button>
        </div>
        <div class="form-group">
          <button type="button" class="btn btn-primary mr-3" onclick="resetPassword()" form="manage">Restablecer Contraseña</button>
          <a href="login.php" class="btn btn-outline-secondary">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
  function generatePassword() {
    var generatedPassword = generateRandomPassword();
    $('#generatedPassword').val(generatedPassword);
  }

  function generateRandomPassword() {
    var length = 10;
    var charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    var password = '';
    for (var i = 0; i < length; i++) {
      var randomIndex = Math.floor(Math.random() * charset.length);
      password += charset.charAt(randomIndex);
    }
    return password;
  }

  function start_load() {
    console.log("Iniciando carga...");
  }

  function end_load() {
    console.log("Finalizando carga...");
  }

  function resetPassword() {
    var email = $('#email').val();
    console.log(email);
    var newPassword = $('#generatedPassword').val();
    console.log(newPassword);

    if (!newPassword) {
      alert('Genera una contraseña antes de restablecerla.');
      return;
    }

    start_load();

    var data = {
      email: email,
      password: newPassword
    };

    $.ajax({
      url: 'ajax.php?action=resetPassword',
      data: data,
      method: 'POST',
      success: function(resp) {
        console.log("Respuesta del Servidor:", resp);
        if (resp == 1) {
          // alert('Contraseña restablecida con éxito');
          alert_toast('Contraseña reestablecida', "success");
          setTimeout(function() {
            location.href = 'index.php?page=user_list'
          }, 2000)
        } else if (resp == 2) {
          $('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> El correo electrónico no está registrado.</div>');
        }
      },
      complete: function() {
        end_load();
      }
    });
  }
</script>
<?php include 'footer.php' ?>