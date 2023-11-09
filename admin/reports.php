<?php include 'db_connect.php' ?>
<div class="col-md-12">
  <div class="card card-outline card-success">
    <div class="card-header">
      <b>Reportes de Proyectos por Donaciones</b>
      <div class="card-tools">
        <!-- <button class="btn btn-flat btn-sm bg-gradient-success btn-success" id="print"><i class="fa fa-print"></i> Imprimir</button> -->
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive" id="printable">
        <table id="example23" class="table m-0 table-bordered">
          <!--  <colgroup>
                  <col width="5%">
                  <col width="30%">
                  <col width="35%">
                  <col width="15%">
                  <col width="15%">
                </colgroup> -->
          <thead>
            <th>#</th>
            <th>Proyecto</th>
            <th>Total Donaciones</th>
            <th>Total Gastos</th>
            <th>Inversión Total</th>
            <th>Saldo Disponible</th>
            <th>Estado</th>
          </thead>
          <tbody>
            <?php
            $i = 1;
            $stat = array("Pendiente", "Iniciado", "En progreso", "En espera", "Terminado", "Confirmado");
            $where = "";
            if ($_SESSION['login_type'] == 2) {
              $where = " where manager_id = '{$_SESSION['login_id']}' ";
            } elseif ($_SESSION['login_type'] == 3) {
              $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
            }
            $qry = $conn->query("SELECT p.*, d.*, i.total_investment, SUM(d.donation_amount) as total_donation FROM project_list as p
            INNER JOIN client_project_approval as d ON p.id = d.project_list_id
            LEFT JOIN (
              SELECT project_id, SUM(amount) AS total_investment
              FROM investment_list
              GROUP BY project_id
            ) AS i ON p.id = i.project_id
            $where GROUP BY p.id ORDER BY p.name ASC");

            while ($row = $qry->fetch_assoc()) :
              $tprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']}")->num_rows;
              $cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']} and status = 3")->num_rows;
              $prog = $tprog > 0 ? ($cprog / $tprog) * 100 : 0;
              $prog = $prog > 0 ?  number_format($prog, 2) : $prog;
              $prod = $conn->query("SELECT * FROM user_productivity where project_id = {$row['id']}")->num_rows;
              $dur = $conn->query("SELECT sum(time_rendered) as duration FROM user_productivity where project_id = {$row['id']}");
              $dur = $dur->num_rows > 0 ? $dur->fetch_assoc()['duration'] : 0;
              if ($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])) :
                if ($prod  > 0  || $cprog > 0)
                  $row['status'] = 2;
                else
                  $row['status'] = 1;
              elseif ($row['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])) :
                $row['status'] = 4;
              endif;
            ?>
              <tr>
                <td>
                  <?php echo $i++ ?>
                </td>
                <td>
                  <a>
                    <?php echo ucwords($row['name']) ?>
                  </a>
                  <br>
                  <!-- <small>
                    Finaliza: <?php echo date("Y-m-d", strtotime($row['end_date'])) ?>
                  </small> -->
                </td>
                <td class="text-center">
                  <?php echo ucwords($row['total_donation']) ?>
                </td>
                <td class="text-center">
                  Q. <?php echo ucwords($row['total_investment']) . ' ' ?>
                </td>
                <td class="text-center">
                  Q <?php echo ucwords($row['price']) ?>
                </td>
                <td class="text-center">
                  Q <?php echo ucwords ($row['total_donation'] - $row['total_investment'] )  ?>
                </td>       

                <!-- <td class="project_progress">
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
                    </div>
                  </div>
                  <small>
                    <?php echo $prog ?>% Complete
                  </small>
                </td> -->
                <td class="project-state">
                  <?php
                  if ($stat[$row['status']] == 'Pendiente') {
                    echo "<span class='badge badge-secondary'>{$stat[$row['status']]}</span>";
                  } elseif ($stat[$row['status']] == 'Iniciado') {
                    echo "<span class='badge badge-primary'>{$stat[$row['status']]}</span>";
                  } elseif ($stat[$row['status']] == 'En progreso') {
                    echo "<span class='badge badge-info'>{$stat[$row['status']]}</span>";
                  } elseif ($stat[$row['status']] == 'En espera') {
                    echo "<span class='badge badge-warning'>{$stat[$row['status']]}</span>";
                  } elseif ($stat[$row['status']] == 'Terminado') {
                    echo "<span class='badge badge-danger'>{$stat[$row['status']]}</span>";
                  } elseif ($stat[$row['status']] == 'Confirmado') {
                    echo "<span class='badge badge-success'>{$stat[$row['status']]}</span>";
                  }
                  ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#example23').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });
  });

  $('#print').click(function() {
    start_load()
    var _h = $('head').clone()
    var _p = $('#printable').clone()
    var _d = "<p class='text-center'><b>Project Progress Report as of (<?php echo date("F d, Y") ?>)</b></p>"
    _p.prepend(_d)
    _p.prepend(_h)
    var nw = window.open("", "", "width=900,height=600")
    nw.document.write(_p.html())
    nw.document.close()
    nw.print()
    setTimeout(function() {
      nw.close()
      end_load()
    }, 750)
  })
</script>