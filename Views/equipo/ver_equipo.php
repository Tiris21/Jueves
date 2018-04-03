<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?=URL?>Equipo">Mi Equipo</a>
        </li>
        <li class="breadcrumb-item active">Equipo de <?= $usr['nombre'] ?></li>
      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-12 col-sm-12 mb-3">
         
          <h1> <i class="fa fa-fw fa-users mb-3"></i> Equipo de <?= $usr['nombre'] ?> </h1>
          <div class="table-responsive">
            
            <table class="table table-bordered" id="dataTableEquipo" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No. Empleado</th>
                  <th>Nombre</th>
                  <th>Puesto</th>
                  <th>Correo</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>

              <?php foreach ($equipo_subequipo as $e) { ?>
                <tr>
                  <td><?= $e['id_usuario'] ?></td>
                  <td><?= $e['nombre'] ?></td>
                  <td><?= $e['puesto'] ?></td>
                  <td><?= $e['correo'] ?></td>
                  <td>
                    <select class="custom-select acciones" id="select_acciones" >
                      <option selected value="seleccionar">Seleccionar..</option>
                      <option value="tablero-<?=$e['id_usuario']?>">Ver Tablero</option>
                      <?php if ($tienen_equipo[$e['id_usuario']]) { ?>
                        <option value="equipo-<?=$e['id_usuario']?>">Ver Equipo</option>
                        <!-- <option value="equipo-<?=$e['id_usuario']?>">Ver Tablero de Equipo</option> -->
                      <?php } ?>
                    </select>
                  </td>
                </tr>
              <?php } ?>  
                
              </tbody>
            </table>

          </div>
        </div>
        
      <!-- </div> -->
    </div>
    </div>

<script>

$(document).ready(function() {

  $('#dataTableEquipo').DataTable({
      
        "language": {
            "lengthMenu": "Mostrar _MENU_ filas por pagina",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No se encontraron resultados",
            "search": "Buscar",
            "paginate": { 
              "search": "Buscar",
              "first": "Primero",
              "last": "Ultimo",
              "next": "Siguiente",
              "previous": "Anterior"
            },
            "infoFiltered": "(filtrado de _MAX_ registros totales)"
        }
  });

  if ("<?=$puede_ver?>" == "carefully") {

    $('#advertenciaModal').on('hidden.bs.modal', function (e) {
        window.location.href = "<?=URL?>Equipo";
    })
    $('#advertenciaModal').modal("show"); 

  }

});


$('.acciones').change(function() {
  var opcion = $(this).val();
  opcion = opcion.split('-');
  var opval = opcion[0];

  if(opval == "equipo"){ 
      window.location.href = "<?=URL?>Equipo/Ver/"+opcion[1];

  }else if(opval == "tablero") {
      window.location.href = "<?=URL?>Equipo/Tablero/"+opcion[1];
  }
  
  // else if(opval == "comentar") {
  //     $('#comentar-id_objetivo').val(opcion[1]);
  //     $('#comentarModal').modal("show"); 
  // }

  $(this).val("seleccionar");

 

});

</script>



    <!-- Modal ADVERTENCIA -->
    <div class="modal fade" id="advertenciaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ADVERTENCIA!</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" id="ver-body">
            <p> <strong> Lo siento, no tienes permiso para ver el contenido de esta página :( </strong> </p>
            <p> <strong> Se te redericcionará a la pagina de tú equipo </strong> </p>
            <p class="text-center text-danger" style="font-size: 12em;"> <i class="fa fa-ban" aria-hidden="true"></i> </p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>