<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?=URL?>Home">Home</a>
        </li>
        <li class="breadcrumb-item active">Mi Equipo</li>
      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-12 col-sm-12 mb-3">
         
          <h1> <i class="fa fa-fw fa-users mb-3"></i> Mi Equipo</h1>
      <!-- <div class="card mb-3"> -->
        <!-- <div class="card-header">
          <i class="fa fa-table"></i> Data Table Example</div>
        <div class="card-body"> -->
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
              <!-- <tfoot>
                <tr>
                  <td>234</td>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Office</th>
                  <th>Age</th>
                  <th>Start date</th>
                  <th>Salary</th>
                  <td>
                    <select class="custom-select" id="inputGroupSelect01">
                      <option selected>Seleccionar..</option>
                      <option value="1">Ver Objetivos</option>
                      <option value="3">Asignar Objetivo</option>
                      <option value="2">Eliminar</option>
                    </select>
                  </td>
                </tr>
              </tfoot> -->
              <tbody>

              <?php foreach ($mi_equipo as $e) { ?>
                <tr>
                  <td><?= $e['id_usuario'] ?></td>
                  <td><?= $e['nombre'] ?></td>
                  <td><?= $e['puesto'] ?></td>
                  <td><?= $e['correo'] ?></td>
                  <td>
                    <select class="custom-select acciones" id="select_acciones">
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