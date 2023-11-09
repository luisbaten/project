<?php
include 'db_connect.php';
$stat = array("Pendiente", "Iniciado", "En progreso", "En espera", "Terminado", "Confirmado");
$qry = $conn->query("SELECT * FROM project_list where id = " . $_GET['id'])->fetch_array();
foreach ($qry as $k => $v) {
  $$k = $v;
}

$manager = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where id = $manager_id");
$manager = $manager->num_rows > 0 ? $manager->fetch_array() : array();
?>
<div class="col-lg-12">
  <div class="row">
    <div class="col-md-12">
      <div class="callout callout-info">
        <div class="col-md-12">
          <div class="row">
            <div class="col-sm-6">
              <dl>
                <dt><b class="border-bottom border-primary">Nombre proyecto</b></dt>
                <dd><?php echo ucwords($name) ?></dd>
                <dt><b class="border-bottom border-primary">Descripcion</b></dt>
                <dd><?php echo html_entity_decode($description) ?></dd>
              </dl>
            </div>
            <div class="col-md-6">
              <dl>
                <dt><b class="border-bottom border-primary">Fecha inicio</b></dt>
                <dd><?php echo date("F d, Y", strtotime($start_date)) ?></dd>
              </dl>
              <dl>
                <dt><b class="border-bottom border-primary">Fecha fin</b></dt>
                <dd><?php echo date("F d, Y", strtotime($end_date)) ?></dd>
              </dl>
              <dl>
                <dt><b class="border-bottom border-primary">Estado</b></dt>
                <dd>
                  <?php
                  if ($stat[$status] == 'Pendiente') {
                    echo "<span class='badge badge-secondary'>{$stat[$status]}</span>";
                  } elseif ($stat[$status] == 'Iniciado') {
                    echo "<span class='badge badge-primary'>{$stat[$status]}</span>";
                  } elseif ($stat[$status] == 'En progreso') {
                    echo "<span class='badge badge-info'>{$stat[$status]}</span>";
                  } elseif ($stat[$status] == 'En espera') {
                    echo "<span class='badge badge-warning'>{$stat[$status]}</span>";
                  } elseif ($stat[$status] == 'Terminado') {
                    echo "<span class='badge badge-danger'>{$stat[$status]}</span>";
                  } elseif ($stat[$status] == 'Confirmado') {
                    echo "<span class='badge badge-success'>{$stat[$status]}</span>";
                  }
                  ?>
                </dd>
              </dl>
              <dl>
                <dt><b class="border-bottom border-primary">Proyectos</b></dt>
                <dd>
                  <?php if (isset($manager['id'])) : ?>
                    <div class="d-flex align-items-center mt-1">
                      <img class="img-circle img-thumbnail p-0 shadow-sm border-info img-sm mr-3" src="assets/uploads/<?php echo $manager['avatar'] ?>" alt="Avatar">
                      <b><?php echo ucwords($manager['name']) ?></b>
                    </div>
                  <?php else : ?>
                    <small><i>Eliminar de base de datos</i></small>
                  <?php endif; ?>
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <span><b>Miembros del equipo:</b></span>
          <div class="card-tools">
            <!-- <button class="btn btn-primary bg-gradient-primary btn-sm" type="button" id="manage_team">Manage</button> -->
          </div>
        </div>
        <div class="card-body">
          <ul class="users-list clearfix">
            <?php
            if (!empty($user_ids)) :
              $members = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where id in ($user_ids) order by concat(firstname,' ',lastname) asc");
              while ($row = $members->fetch_assoc()) :
            ?>
                <li>
                  <img src="assets/uploads/<?php echo $row['avatar'] ?>" alt="User Image">
                  <a class="users-list-name" href="javascript:void(0)"><?php echo ucwords($row['name']) ?></a>
                  <!-- <span class="users-list-date">Today</span> -->
                </li>
            <?php
              endwhile;
            endif;
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>    
<style>
  .users-list>li img {
    border-radius: 50%;
    height: 67px;
    width: 67px;
    object-fit: cover;
  }

  .users-list>li {
    width: 33.33% !important
  }

  .truncate {
    -webkit-line-clamp: 1 !important;
  }
</style>