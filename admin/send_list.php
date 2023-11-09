<?php include 'db_connect.php'; ?>
<h1>Lista de Solicitudes de Proyectos</h1>
<div class="col-lg-12">
  <div class="card card-outline card-success">
    <div class="card-body">
      <table class="table table-hover table-condensed" id="list">
        <colgroup>
          <col width="5%">
          <col width="15%">
          <col width="15%">
          <col width="15%">
          <col width="20%">
          <col width="15%">
          <col width="15%">
        </colgroup>
        <thead>
          <tr>
            <th class="text-center">#</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>DPI</th>
            <th>Teléfono</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $qry = $conn->query("SELECT * FROM send_project ORDER BY id DESC");
          while ($row = $qry->fetch_assoc()) :
          ?>
            <tr>
              <th class="text-center"><?php echo $i++ ?></th>
              <td><?php echo $row['primerNombre'] . ' ' . $row['segundoNombre'] ?></td>
              <td><?php echo $row['primerApellido'] . ' ' . $row['segundoApellido'] ?></td>
              <td><?php echo $row['dpi'] ?></td>
              <td><?php echo $row['telefono'] ?></td>
              <td><?php echo $row['descripcion'] ?></td>
              <td>
                <?php if ($row['status'] == 1) : ?>
                  <span class="badge badge-success">Aceptada</span>
                <?php elseif ($row['status'] == 2) : ?>
                  <span class="badge badge-danger">Declinada</span>
                <?php else : ?>
                  <span class="badge badge-warning">Pendiente</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  Acciones
                </button>
                <div class="dropdown-menu">
                  <div class="text-center">
                    <button class="btn btn-flat btn-sm btn-default btn-primary btn-activate" data-id="<?php echo $row['id'] ?>" data-is_approved="<?php echo $row['status'] == 0 ? 1 : 0; ?>">
                      <?php echo $row['status'] == 0 ? 'Activar' : 'Desactivar'; ?>
                    </button>
                    <button class="btn btn-flat btn-sm btn-default btn-decline" data-id="<?php echo $row['id'] ?>">
                      Declinar
                    </button>
                  </div>
                  <a class="dropdown-item view_project" href="./index.php?page=view_send_project&id=<?php echo $row['id'] ?>" data-id="<?php echo $row['id'] ?>">Ver</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item delete_request" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Eliminar</a>
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

    $('.delete_request').click(function() {
      _conf("¿Estás seguro de eliminarlo?", "delete_request", [$(this).attr('data-id')])
    });
  });

  function delete_request($id) {
    start_load();
    $.ajax({
      url: 'ajax.php?action=delete_request',
      method: 'POST',
      data: {
        id: $id
      },
      success: function(resp) {
        if (resp == 1) {
          alert_toast("Datos eliminados exitosamente", 'success');
          setTimeout(function() {
            location.reload();
          }, 1500);
        }
      }
    });
  }

  $(document).ready(function() {
    $('.btn-activate').click(function() {
      let id = $(this).data('id');
      let is_approved = $(this).data('is_approved');
      console.log("Antes de la solicitud AJAX - ID:", id, "is_approved:", is_approved);
      updateDonationStatus(id, is_approved);
    });
    $('.btn-decline').click(function() {
      let id = $(this).data('id');
      console.log("Botón Declinar presionado - ID:", id);
      updateDeclineStatus(id);
    });

    function updateDonationStatus(id, is_approved) {
      $.ajax({
        url: 'ajax.php?action=update_project_status',
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

  function updateDeclineStatus(id) {
    $.ajax({
      url: 'ajax.php?action=update_project_status',
      method: 'POST',
      data: {
        id: id,
        is_approved: 2
      },
      success: function(resp) {
        console.log("Respuesta AJAX Declinar:", resp);
        if (resp == 1) {
          alert_toast('Solicitud declinada', 'success');
          setTimeout(function() {
            location.reload();
          }, 1000);
        } else {
          alert_toast('Ocurrió un error al declinar la solicitud', 'error');
        }
      }
    });
  }
</script>