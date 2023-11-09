<?php include 'db_connect.php' ?>
<h1>Lista de Inversiones</h1>
<div class="col-lg-12">
  <div class="card card-outline card-success">
    <div class="card-header">
      <div class="card-tools">
        <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_investment"><i class="fa fa-plus"></i> Agregar</a>
      </div>
    </div>
    <div class="card-body">
      <table class="table table-hover table-condensed" id="list">
        <colgroup>
          <col width="5%">
          <col width="10%">
          <col width="15%">
          <col width="15%">
          <col width="15%">
          <col width="15%">
          <col width="10%">
          <!-- <col width="10%"> -->
        </colgroup>
        <thead>
          <tr>
            <th class="text-center">#</th>
            <th class="text-center">Fecha Inversión</th>
            <th>Proyecto</th>
            <th>Cantidad</th>
            <th>Inicio proyecto</th>
            <th>Descripción</th>
            <!-- <th>Estado proyecto</th>
            <th>Estado Inversión</th> -->
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $where = "";
          if ($_SESSION['login_type'] == 2) {
            $where = " WHERE p.manager_id = '{$_SESSION['login_id']}' ";
          } elseif ($_SESSION['login_type'] == 3) {
            $where = " WHERE p.id IN (SELECT DISTINCT project_id FROM investment_list WHERE user_id = '{$_SESSION['login_id']}') ";
          }

          $stat = array("Pendiente", "Iniciado", "En progreso", "En espera", "Terminado", "Confirmado");
          $qry = $conn->query("SELECT i.*, p.name as pname, p.start_date, p.status as pstatus, p.end_date, p.id as pid 
          FROM investment_list i 
          INNER JOIN project_list p ON p.id = i.project_id $where ORDER BY p.name ASC");

          while ($row = $qry->fetch_assoc()) :
            $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
            unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
            $desc = strtr(html_entity_decode($row['description']), $trans);
            $desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);

          ?>
            <tr>
              <td class="text-center"><?php echo $i++ ?></td>
              <td class="text-center"><b><?php echo ucwords(date('d-m-Y', strtotime($row['date_created']))) ?></b></td>
              <td>
                <p><b><?php echo ucwords($row['pname']) ?></b></p>
              </td>
              <td>
                <p><b><?php echo $row['amount'] ?></b></p>
                <!-- <p class="truncate"><?php echo strip_tags($desc) ?></p> -->
              </td>
              <td><b><?php echo date("d-m-Y", strtotime($row['start_date'])) ?></b></td>
              <td><b><?php echo $row['description'] ?></b></td>
              <!-- <td class="text-center">
                <?php
                if ($stat[$row['pstatus']] == 'Pendiente') {
                  echo "<span class='badge badge-secondary'>{$stat[$row['pstatus']]}</span>";
                } elseif ($stat[$row['pstatus']] == 'Iniciado') {
                  echo "<span class='badge badge-primary'>{$stat[$row['pstatus']]}</span>";
                } elseif ($stat[$row['pstatus']] == 'En progreso') {
                  echo "<span class='badge badge-info'>{$stat[$row['pstatus']]}</span>";
                } elseif ($stat[$row['pstatus']] == 'En espera') {
                  echo "<span class='badge badge-warning'>{$stat[$row['pstatus']]}</span>";
                } elseif ($stat[$row['pstatus']] == 'Terminado') {
                  echo "<span class='badge badge-danger'>{$stat[$row['pstatus']]}</span>";
                } elseif ($stat[$row['pstatus']] == 'Confirmado') {
                  echo "<span class='badge badge-success'>{$stat[$row['pstatus']]}</span>";
                }
                ?>
              </td> -->
              <!-- <td>
                <?php
                if ($row['status'] == 1) {
                  echo "<span class='badge badge-secondary'>Pendiente</span>";
                } elseif ($row['status'] == 2) {
                  echo "<span class='badge badge-primary'>En progreso</span>";
                } elseif ($row['status'] == 3) {
                  echo "<span class='badge badge-success'>Confirmado</span>";
                }
                ?>
              </td> -->
              <td class="text-center">
                <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  Acciones
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="./index.php?page=edit_investment&id=<?php echo $row['id'] ?>">Editar</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item delete_investment" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Borrar</a>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<style>
  table p {
    margin: unset !important;
  }

  table td {
    vertical-align: middle !important
  }
</style>
<script>
  $(document).ready(function() {
    $('#list').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });
    $('.delete_investment').click(function() {
      _conf("Estas seguro de eliminarlo?", "delete_investment", [$(this).attr('data-id')])
    })

  })



  function delete_investment($id) {
    start_load()
    $.ajax({
      url: 'ajax.php?action=delete_investment',
      method: 'POST',
      data: {
        id: $id
      },
      success: function(resp) {
        if (resp == 1) {
          alert_toast("Datos eliminados", 'success')
          setTimeout(function() {
            location.reload()
          }, 1500)
        }
      }
    })
  }
</script>