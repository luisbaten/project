<?php
if (isset($_POST['login'])) {
  $emailcon = $_POST['emailcont'];
  $password = md5($_POST['password']);
  $query = mysqli_query($con, "select id, email, status from clients where status = 1 and  (email='$emailcon' || contact='$emailcon') && password='$password' ");
  $ret = mysqli_fetch_array($query);
  if ($ret > 0) {
    $_SESSION['fosuid'] = $ret['id'];
    $_SESSION['uemail'] = $ret['email'];
    $_SESSION['us_status'] = $ret['status'];

    if ($_SESSION['us_status'] == 1) {
      echo "<script>window.location.href='index.php'</script>";
    }
  } else {
    echo "<script>alert('correo o contraseña incorrecta!');</script>";
  }
}
?>

<div class="log-popup text-center">
  <div class="sign-popup-wrapper brd-rd5">
    <div class="sign-popup-inner brd-rd5">
      <a class="log-close-btn" href="#" title="" itemprop="url"><i class="fa fa-close"></i></a>
      <div class="sign-popup-title text-center">
        <h4 itemprop="headline">INICIAR SESION</h4>
      </div>

      <form class="sign-form" method="post">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-lg-12">
            <input class="brd-rd3" name="emailcont" id="email" placeholder="Ingrese correo " required>
          </div>
          <div class="col-md-12 col-sm-12 col-lg-12">
            <input class="brd-rd3" type="password" id="password" name="password" placeholder="Contraseña" required>
          </div>
          <div class="col-md-12 col-sm-12 col-lg-12">
            <button class="red-bg brd-rd3" type="submit" name="login">INICIAR SESION</button>
          </div>
          <div class="col-md-12 col-sm-12 col-lg-12">
            <a class="sign-popup-btn" href="#" title="Registro" itemprop="url">REGISTRARSE</a>
   
          </div>
        </div>
      </form>
    </div>
  </div>
</div>