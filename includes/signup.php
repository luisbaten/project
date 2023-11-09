  <?php
  if (isset($_POST['submit'])) {
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $contno = $_POST['mobilenumber'];
    // $dpi = $_POST['dpi'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $ret = mysqli_query($con, "select Email from tbluser where Email='$email' || MobileNumber='$contno'");
    $result = mysqli_fetch_array($ret);
    if ($result > 0) {
      echo "<script>alert('Este correo o número ya se encuentran en uso');</script>";
    } else {
      $query = mysqli_query($con, "insert into clients(firstName, lastName, contact, email, password) value('$fname', '$lname','$contno', '$email', '$password' )");
      if ($query) {
        echo "<script>alert('Tus datos han sido registrados');</script>";
        echo "<script>window.location.href='index.php'</script>";
      } else {
        echo "<script>alert('A ocurrido un error. Vuelva a intentarlo.');</script>";
        echo "<script>window.location.href='index.php'</script>";
      }
    }
  }

  ?>

  <!-- Javascript for password confirmation-->
  <script type="text/javascript">
    function checkpass() {
      if (document.signup.password.value != document.signup.repeatpassword.value) {
        alert('Password and Repeat Password field does not match');
        document.signup.repeatpassword.focus();
        return false;
      }
      return true;
    }
  </script>
  <div class="sign-popup text-center">
    <div class="sign-popup-wrapper brd-rd5">
      <div class="sign-popup-inner brd-rd5">
        <a class="sign-close-btn" href="#" title="" itemprop="url"><i class="fa fa-close"></i></a>
        <div class="sign-popup-title text-center">
          <h4 itemprop="headline">REGISTRO</h4>
        </div>

        <form class="sign-form" name="signup" onsubmit="return checkpass();" method="post">
          <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6">
              <input class="brd-rd3" type="text" id="firstname" name="firstname" required="true" placeholder="Nombres">
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6">
              <input class="brd-rd3" type="text" id="lastname" name="lastname" placeholder="Apellidos">
            </div>
            <div class="col-md-12 col-sm-12 col-lg-12">
              <input class="brd-rd3" type="email" name="email" required="true" placeholder="Correo">
            </div>
            <!-- <div class="col-md-12 col-sm-12 col-lg-12">
              <input class="brd-rd3" id="dpi" name="dpi" required="true" maxlength="15" pattern="[0-9]{12,15}" title="dpi válido" placeholder="Ingrese # DPI">
            </div> -->
            <div class="col-md-12 col-sm-12 col-lg-12">
              <input class="brd-rd3" id="mobilenumber" name="mobilenumber" required="true" maxlength="8" pattern="[0-9]{8}" title="Teléfono debe contener 8 dígitos" placeholder="Número de Teléfono">
            </div>

            <div class="col-md-12 col-sm-12 col-lg-12">
              <input class="brd-rd3" type="password" name="password" required="true" required="true" minlength="7" title="Contraseña debe contener 7 carácteres o más" placeholder="Contraseña">
            </div>

            <div class="col-md-12 col-sm-12 col-lg-12">
              <input class="brd-rd3" type="password" id="repeatpassword" name="repeatpassword" required="true" placeholder="Confirmar Contraseña">
            </div>
            <div class="col-md-12 col-sm-12 col-lg-12">
              <button class="red-bg brd-rd3" type="submit" name="submit">REGISTRARSE</button>
            </div>
            <div class="col-md-12 col-sm-12 col-lg-12">
              <a class="sign-btn" href="#" title="" itemprop="url">Estas Registrado? Iniciar sesión</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>