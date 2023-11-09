<?php
session_start();
include_once('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <title>Donaciones</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/icons.min.css">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/red-color.css">
  <link rel="stylesheet" href="assets/css/yellow-color.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
</head>

<body itemscope>
  <?php include_once('includes/header.php'); ?>


  <section class="page-section" id="menu">
    <div class="block less-spacing gray-bg top-padd30">
      <div class="row welcome text-center welcome">
        <div class="col-12">
          <h1 class="sign-popup-title text-center">VISIÓN</h1>
          <div class="container">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="sec-box">

                  <p style="color: black;">Queremos ser una organización que agregue valor a personas de escasos recursos y con capacidades diferentes. </p>

                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="pagination-wrapper text-center">
          <ul class="pagination justify-content-center">

          </ul>
        </div><!-- Pagination Wrapper -->
      </div>
      <div class="col-12">
        <h1 class="sign-popup-title text-center">MISIÓN</h1>
        <div class="container">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
              <div class="sec-box">

                <p style="color: black; text-align:center">Somos una organización no Gubernamental sin fines de lucro, que realiza el trabajo dirigido a personas de escasos recursos y con capacidades especiales. Construcción de viviendas, operaciones
                  a niños para que puedan caminar, entrega de víveres e inclusión social según sea su caso. Nuestra área de trabajo es en el occidente de Guatemala. </p>

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center">
        <a style="width: 30%;" name="send" id="send" class="btn btn-primary" href="#" role="button">Enviar Solicitud</a>
      </div>
      <div class="pagination-wrapper text-center">
        <ul class="pagination justify-content-center">

        </ul>
      </div><!-- Pagination Wrapper -->

  </section>



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
</body>

</html>