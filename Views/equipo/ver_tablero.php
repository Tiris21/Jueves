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
        <li class="breadcrumb-item active">Tablero de <?= $usr['nombre'] ?></li>
      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-9">
          <h1> <i class="fa fa-fw fa-table"></i> Tablero De <?= $usr['nombre'] ?></h1> 
        </div>
      </div>

      <div class="row">
        <div class="col-xl-12 col-sm-12 mb-3">
          <div class="table-responsive tablero">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Objetivo</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Vencimiento</th>
                  <th>Dias p. Venc.</th>
                  <th>Estatus</th>
                  <th>T.A.</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
              <?php 
                foreach ($objetivos_usuario as $obj) {
                  $c = getColorPorPorcentaje($obj['avance']);
              ?>
                <tr>
                  <td> <?= $obj['titulo'] ?> </td>
                  <td><?= formatearFecha($obj['fecha_asignacion']) ?></td>
                  <td><?= formatearFecha($obj['fecha_vencimiento']) ?></td>
                  <td><?= (difDiasAHoy($obj['fecha_vencimiento']) < 0) ? 0 : difDiasAHoy($obj['fecha_vencimiento']) ?> </td>
                  <td class="text-white bg-<?=$c?>"><?= $obj['avance'] ?>% </td>
                  <td> <h4 class="text-danger"> <?= ($obj['tipo_avance'] == 'asignado') ? '<i class="fa fa-fw fa-support"></i>' : '' ?></h4> </td>
                  <td>
                    <select class="custom-select acciones">
                      <option value="seleccionar" selected>Seleccionar..</option>
                      <option value="ver-<?=$obj['id_objetivo']?>">Ver Detalle</option>
                      <option value="comentar-<?=$obj['id_objetivo']?>">Comentar</option>
                    </select>
                  </td>
                </tr>  
                 
              <?php 
                }
              ?>
                   
              </tbody>

            </table>
          </div>
        </div>
      </div> <!-- / row -->
    </div>
</div>


<script>

    $(document).ready(function() {

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

        if(opval=="ver"){ 
            window.location.href = "<?=URL?>Objetivos/ver/"+opcion[1];

        }else if(opval == "comentar") {
            $('#comentar-id_objetivo').val(opcion[1]);
            $('#comentarModal').modal("show"); 
        }

        $(this).val("seleccionar");
    });
</script>



<!-- Modal COMENTAR -->
<div class="modal fade" id="comentarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Comentar Objetivo</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?=URL?>tablero/comentar" enctype="multipart/form-data">
          
          <div class="form-group">
            <label>Comentario</label>
            <textarea class="form-control" name="comentario" rows="2"></textarea>
          </div>

          <div class="form-group">
            <label for="archivo">Cargar archivo (opcional)</label>
            <input type="file" class="form-control-file" id="archivo" name="archivo" accept="application/pdf, .doc, .docx, .xlsx, .xls">
          </div>

          <input type="hidden" id="comentar-id_objetivo" name="id_objetivo">
          <input type="hidden" name="tablero_ver" value="<?=$usr['id_usuario']?>">

      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" type="submit">Aceptar</button>
        </form>
      </div>
    </div>
  </div>
</div>



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
            <p> <strong> Se te redericcionará a la pagina de tu equipo </strong> </p>
            <p class="text-center text-danger" style="font-size: 12em;"> <i class="fa fa-ban" aria-hidden="true"></i> </p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>