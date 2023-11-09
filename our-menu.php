<?php
session_start();
include_once('includes/dbconnection.php');

if (isset($_POST['addcart'])) {
  // print_r($_POST);
  $foodid = $_POST['foodid'];
  $amount = floatval($_POST['donation_amount']);
  $clientid = $_SESSION['fosuid'];
  // $depositPhoto = $_FILES['deposit_photo']['name'];
  $depositDate = $_POST['deposit_date'];
  $bankName = $_POST['bank_name'];

  if (!empty($_FILES['deposit_photo']['tmp_name'])) {
    $upload_path = 'assets/img/inversion/';
    $fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['deposit_photo']['name'];
    $move = move_uploaded_file($_FILES['deposit_photo']['tmp_name'], $upload_path . $fname);

    if ($move) {
      // echo "<script>alert('Imagen subida y guardada con éxito');</script>";
      $depositPhoto = $fname;
    } else {
      echo "<script>alert('Error al mover la imagen');</script>";
    }
  } else {
    echo "<script>alert('No se seleccionó ninguna imagen');</script>";
    $depositPhoto = ""; // O establece un valor predeterminado si no se seleccionó ninguna imagen
  }

  $query_insert = mysqli_query($con, "INSERT INTO client_project_approval (client_id, project_list_id, donation_amount, deposit_photo, deposit_date, bank_name) VALUES ('$clientid', '$foodid', '$amount', '$depositPhoto', '$depositDate', '$bankName') ");

  if ($query_insert) {
    $query_update = mysqli_query($con, "UPDATE project_list SET total_donations = total_donations + '$amount' WHERE id = '$foodid'");

    if ($query_update) {
      echo "<script>alert('Donación exitosa');</script>";
    } else {
      echo "<script>alert('Error al actualizar donaciones');</script>";
    }
  } else {
    echo "<script>alert('A ocurrido un error.');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <title>Donaciones </title>
  <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">


  <link rel="stylesheet" href="assets/css/icons.min.css">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/red-color.css">
  <link rel="stylesheet" href="assets/css/yellow-color.css">
  <link rel="stylesheet" href="assets/css/responsive.css">

  <style>
    .styled-number-input {
      display: flex;
      align-items: center;
    }

    .styled-number-input button {
      width: 30px;
      height: 30px;
      background-color: #f0f0f0;
      border: 1px solid #ccc;
      color: #333;
      font-size: 18px;
      cursor: pointer;
    }

    .styled-number-input input {
      width: 200px;
      height: 30px;
      text-align: center;
      font-size: 16px;
      border: 1px solid #ccc;
    }
  </style>

</head>

<body itemscope>
  <?php include_once('includes/header.php'); ?>

  <section>
    <div class="block">
      <div class="fixed-bg" style="background-image: url(assets/img/ong2.jpg);"></div>
      <div class="page-title-wrapper text-center">
        <div class="col-md-12 col-sm-12 col-lg-12">
          <div class="page-title-inner">
            <h1 itemprop="headline">Nuestros Proyectos</h1>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="block less-spacing gray-bg top-padd30">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="sec-box">
              <div class="remove-ext">
                <div class="row">
                  <?php
                  if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
                    $page_no = $_GET['page_no'];
                  } else {
                    $page_no = 1;
                  }
                  $total_records_per_page = 9;
                  $offset = ($page_no - 1) * $total_records_per_page;
                  $previous_page = $page_no - 1;
                  $next_page = $page_no + 1;
                  $adjacents = "2";
                  $result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM project_list");
                  $total_records = mysqli_fetch_array($result_count);
                  $total_records = $total_records['total_records'];
                  $total_no_of_pages = ceil($total_records / $total_records_per_page);
                  $second_last = $total_no_of_pages - 1; // total page minus 1
                  $result = mysqli_query($con, "SELECT * FROM project_list LIMIT $offset, $total_records_per_page");
                  $num = mysqli_num_rows($result);
                  if ($num > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                      $uniqueModalID = "donationModal_" . $row['id'];
                  ?>

                      <div class="col-md-4 col-sm-6 col-lg-4">
                        <div class="popular-dish-box style2 wow fadeIn" data-wow-delay="0.2s">
                          <div class="popular-dish-thumb">
                            <a title="" itemprop="url"><img src="admin/assets/uploads/project/<?php echo $row['images']; ?>" alt="<?php echo $row['name']; ?>" itemprop="images" width="400" height="180"></a>
                          </div>
                          <div class="popular-dish-info">
                            <h4 itemprop="headline"><a title="" itemprop="url"><?php echo $row['name']; ?></a></h4>
                            <h4 itemprop="headline">
                              <p title="" itemprop="url"><?php echo $row['description']; ?></p>
                            </h4>
                            <div>
                              <span class="price">Inversión: Q. <?php echo $row['price']; ?></span>
                            </div>
                            <p itemprop="description">
                              <input type="hidden" name="foodid" value="<?php echo $row['id']; ?>">
                            </p>
                            <!-- <div class="styled-number-input">
                                <button type="button" class="minus">-</button>
                                <input class="quantity" name="donation_amount" type="number" value="1">
                                <button type="button" class="plus">+</button>
                              </div> -->
                            <br>
                            <div>
                              <?php if ($_SESSION['fosuid'] == "") { ?>
                                <a style="color: #FFFF" class="log-popup-btn btn btn-primary" href="#" title="Ordenar">Donar</a>
                              <?php } else { ?>
                                <button style="color: #FFFF" type="button" class="btn btn-primary donateButton" data-modal-id="<?php echo $uniqueModalID; ?>">Donar</button>
                              <?php } ?>
                            </div>
                            <!-- Modal para los campos adicionales -->
                            <div class="modal fade" id="<?php echo $uniqueModalID; ?>" tabindex="-1" role="dialog" aria-labelledby="donationModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="donationModalLabel">Realizar Donación</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form method="post" id="donationForm" enctype="multipart/form-data">
                                    <div class="modal-body">
                                      <!-- Campos adicionales -->
                                      <input type="hidden" name="foodid" value="<?php echo $row['id']; ?>">
                                      <input type="hidden" name="fosuid" value="<?php echo $_SESSION['fosuid']; ?>">
                                      <label for="deposit_photo">Foto de evidencia de depósito:</label>
                                      <input class="form-control-file" type="file" name="deposit_photo">
                                      <br>
                                      <label for="deposit_date">Fecha de depósito:</label>
                                      <input class="form-control" type="date" name="deposit_date">
                                      <br> <br>
                                      <label for="bank_name">Nombre del banco:</label>
                                      <input class="form-control" type="text" name="bank_name">
                                      <br> <br>
                                      <span class="price">Inversión: Q. <?php echo $row['price']; ?></span> <br> <br>
                                      <div class="styled-number-input">
                                        <button type="button" class="minus">-</button>
                                        <input class="quantity" name="donation_amount" type="number" value="1">
                                        <button type="button" class="plus">+</button>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                      <button name="addcart" style="color: #FFFF" type="submit" class="btn btn-primary">Donar</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div><!-- Popular Dish Box -->
                      </div>
                    <?php }
                  } else { ?>
                    <h3 style="color:red;" align="center">Elemento no encontrado</h3>
                  <?php } ?>
                </div>
              </div>
              <div class="pagination-wrapper text-center">
                <ul class="pagination justify-content-center">

                  <!-- 
<ul class="pagination"> -->
                  <?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } 
                  ?>

                  <li class="page-item prev" <?php if ($page_no <= 1) {
                                                echo "class='disabled'";
                                              } ?>>
                    <a class="page-link brd-rd2" <?php if ($page_no > 1) {
                                                    echo "href='?page_no=$previous_page'";
                                                  } ?>>Anterior</a>
                  </li>

                  <?php
                  if ($total_no_of_pages <= 10) {
                    for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                      if ($counter == $page_no) {
                        echo "<li class='active'><a>$counter</a></li>";
                      } else {
                        echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                      }
                    }
                  } elseif ($total_no_of_pages > 10) {

                    if ($page_no <= 4) {
                      for ($counter = 1; $counter < 8; $counter++) {
                        if ($counter == $page_no) {
                          echo "<li class='active'><a>$counter</a></li>";
                        } else {
                          echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                        }
                      }
                      echo "<li><a>...</a></li>";
                      echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                      echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                    } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                      echo "<li><a href='?page_no=1'>1</a></li>";
                      echo "<li><a href='?page_no=2'>2</a></li>";
                      echo "<li><a>...</a></li>";
                      for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                        if ($counter == $page_no) {
                          echo "<li class='active'><a>$counter</a></li>";
                        } else {
                          echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                        }
                      }
                      echo "<li><a>...</a></li>";
                      echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                      echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                    } else {
                      echo "<li><a href='?page_no=1'>1</a></li>";
                      echo "<li><a href='?page_no=2'>2</a></li>";
                      echo "<li><a>...</a></li>";

                      for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                        if ($counter == $page_no) {
                          echo "<li class='active'><a>$counter</a></li>";
                        } else {
                          echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                        }
                      }
                    }
                  }
                  ?>

                  <li class="page-item next" <?php if ($page_no >= $total_no_of_pages) {
                                                echo "class='disabled'";
                                              } ?>>
                    <a class="page-link brd-rd2" <?php if ($page_no < $total_no_of_pages) {
                                                    echo "href='?page_no=$next_page'";
                                                  } ?>>Siguiente</a>
                  </li>
                  <?php if ($page_no < $total_no_of_pages) { ?>
                    <li class="page-item next"><a class="page-link brd-rd2" href='?page_no=<?php echo $total_no_of_pages; ?>'>Último &rsaquo;&rsaquo;</a></li>
                  <?php
                  } ?>
                </ul>
              </div><!-- Pagination Wrapper -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <?php include_once('includes/footer.php');
  include_once('includes/signin.php');
  include_once('includes/signup.php');
  ?>

  </main><!-- Main Wrapper -->

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/plugins.js"></script>
  <script src="assets/js/main.js"></script>

  <script>
    $(document).ready(function() {
      $(".donateButton").click(function() {
        var uniqueModalID = $(this).data("modal-id");
        $("#" + uniqueModalID).modal("show");
      });

      });
  </script>
  <script>
    $('.styled-number-input button').click(function() {
      var $input = $(this).parent().find('input');
      var val = parseInt($input.val());
      if ($(this).hasClass('plus')) {
        $input.val(val + 1);
      } else {
        $input.val(Math.max(val - 1, 1));
      }
    });
  </script>
</body>

</html>