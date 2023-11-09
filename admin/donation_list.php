<?php include 'db_connect.php' ?>
<h1>Lista de Donaciones</h1>
<div class="col-lg-12">
  <div class="card card-outline card-success">
    <!-- <div class="card-header">
      <?php if ($_SESSION['login_type'] != 3) : ?>
        <div class="card-tools">
          <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_project"><i class="fa fa-plus"></i> Agregar</a>
        </div>
      <?php endif; ?>
    </div> -->
    <div class="card-body">
      <table class="table table-hover table-condensed" id="list">
        <colgroup>
          <col width="5%">
          <col width="15%">
          <col width="15%">
          <col width="15%">
          <col width="15%">
          <col width="15%">
          <col width="15%">
          <col width="15%">
          <col width="20%">
          <col width="10%">
        </colgroup>
        <thead>
          <tr>
            <th class="text-center">#</th>
            <th>Donador</th>
            <th>Fecha depósito</th>
            <th>Depósito</th>
            <th>Banco</th>
            <th>Proyecto</th>
            <th>Monto de Donación</th>
            <th>Fecha de Donación</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $qry = $conn->query("SELECT cpa.*, cl.firstname, cl.lastname, pl.name as project_name FROM client_project_approval cpa
                              JOIN clients cl ON cpa.client_id = cl.id
                              JOIN project_list pl ON cpa.project_list_id = pl.id
                              ORDER BY cpa.id DESC");
          while ($row = $qry->fetch_assoc()) :
          ?>
            <tr>
              <th class="text-center"><?php echo $i++ ?></th>
              <td><?php echo $row['firstname'] . ' ' . $row['lastname'] ?></td>
              <td><?php echo date("d-m-Y", strtotime($row['deposit_date'])) ?></td>
              <td><img src="../assets/img/inversion/<?php echo $row['deposit_photo']; ?>" alt="Depósito" style="width: 50px;"></td>
              <td><?php echo $row['bank_name'] ?></td>
              <td><?php echo $row['project_name'] ?></td>
              <td>Q <?php echo $row['donation_amount'] ?></td>
              <td><?php echo date("d-m-Y", strtotime($row['approval_date'])) ?></td>
              <td>
                <?php echo $row['is_approved'] == 1 ? 'Activo' : 'Inactivo'; ?>
              </td>
              <td class="text-center">
                <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  Acciones
                </button>
                <div class="dropdown-menu">
                  <div class="text-center">
                    <button class="btn btn-flat btn-sm btn-default btn-primary btn-activate" data-id="<?php echo $row['id'] ?>" data-is_approved="<?php echo $row['is_approved'] == 0 ? 1 : 0; ?>">
                      <?php echo $row['is_approved'] == 0 ? 'Activar' : 'Desactivar'; ?>
                    </button>
                  </div>
                  <div class="dropdown-divider"></div>
                  <?php if ($_SESSION['login_type'] != 3) : ?>
                    <a class="dropdown-item" href="./index.php?page=edit_donation&id=<?php echo $row['id'] ?>">Editar</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item delete_donation" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Borrar</a>
                  <?php endif; ?>
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
    $('.delete_donation').click(function() {
      _conf("Estas seguro de eliminarlo?", "delete_donation", [$(this).attr('data-id')])
    })
  })

  function delete_donation($id) {
    start_load()
    $.ajax({
      url: 'ajax.php?action=delete_donation',
      method: 'POST',
      data: {
        id: $id
      },
      success: function(resp) {
        if (resp == 1) {
          alert_toast("Data successfully deleted", 'success')
          setTimeout(function() {
            location.reload()
          }, 1500)

        }
      }
    })
  }

  $(document).ready(function() {
    $('.btn-activate').click(function() {
      let id = $(this).data('id');
      let is_approved = $(this).data('is_approved');
      console.log("Antes de la solicitud AJAX - ID:", id, "is_approved:", is_approved);
      updateDonationStatus(id, is_approved);
    });

    function updateDonationStatus(id, is_approved) {
      $.ajax({
        url: 'ajax.php?action=update_donation_status',
        method: 'POST',
        data: {
          id: id,
          is_approved: is_approved
        },
        success: function(resp) {
          console.log("Respuesta AJAX:", resp);
          if (resp == 1) {
            alert_toast('Estado de donación actualizado', 'success');
            setTimeout(function() {
              location.reload();
            }, 1000);
          } else {
            alert_toast('Ocurrió un error al actualizar el estado', 'error');
          }
        }
      });
    }
  });
</script>