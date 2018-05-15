<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?=URL?>">Home</a>
        </li>
        <li class="breadcrumb-item active">Tablero</li>
      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-9">
          <h1> <i class="fa fa-fw fa-table"></i> Tablero De Mi Equipo</h1> 
        </div>
      </div>

      <div class="row">
        <div class="col-xl-12 col-sm-12 mb-3">
          <div class="table-responsive tablero">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Objetivo</th>
                  <th>Responsable</th>
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
                foreach ($objetivos as $obj) {
                  $c = getColorPorPorcentaje($obj['avance'], $obj['dias'],  $obj['fecha_vencimiento']);
              ?>
                <tr>
                  <td> <?= $obj['titulo'] ?> </td>
                  <td> <?= $obj['nombre'] ?> </td>
                  <td><?= formatearFecha($obj['fecha_asignacion']) ?></td>
                  <td><?= formatearFecha($obj['fecha_vencimiento']) ?></td>
                  <td><?= (difDiasAHoy($obj['fecha_vencimiento']) < 0) ? 0 : difDiasAHoy($obj['fecha_vencimiento']) ?> </td>
                  <td class="text-white bg-<?=$c?>"><?= $obj['avance'] ?>% </td>
                  <td> <h4 <?= ($obj['tipo_avance'] == 'asignado') ? 'data-toggle="tooltip" title="'.array_shift($los_asignados).'"' : '' ?> > <?= ($obj['tipo_avance'] == 'asignado') ? '<i class="fa fa-fw fa-support text-danger"></i>' : '<i class="fa fa-fw fa-user text-secondary"></i>' ?></h4> </td>
                  <td>
                    <select class="custom-select acciones">
                      <option value="seleccionar" selected>Seleccionar..</option>
                      <option value="ver-<?=$obj['id_objetivo']?>">Ver Detalle</option>
                      <option value="comentar-<?=$obj['id_objetivo']?>">Comentar</option>
                      <?php if ( $_SESSION['id_usuario'] == $obj['asignador'] ) { ?>
                        <option value="editar-<?=$obj['id_objetivo']?>">Editar</option>
                        <option value="eliminar-<?=$obj['id_objetivo']?>">Eliminar</option>
                      <?php } ?>
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
    $('.acciones').change(function() {
        var opcion = $(this).val();
        opcion = opcion.split('-');
        var opval = opcion[0];

        if(opval=="ver"){ 
            window.location.href = "<?=URL?>Objetivos/ver/"+opcion[1];

        
        }else if(opval == "editar") {
            $('#editar-id_objetivo').val(opcion[1]);
            $.ajax({ 
              type: "post",
              url:  '<?=URL?>tablero/ajaxObjetivo', 
              dataType: 'json',
              data: {
                    id_obj: opcion[1],
              },
              success: function(result){
                $('#tituloE').val(result.titulo);
                $('#descripcionE').text(result.descripcion);
                $('#dias_duracionE').val(result.dias);
                var fa = result.fecha_asignacion.split(' ');
                $('#fecha_inicioE').val(fa[0]);
                fa = result.fecha_vencimiento.split(' ');
                $('#fecha_vencimientoE').val(fa[0]);
                $('#editar-prioridad').val(result.prioridad);
              }
            });
            $('#editarModal').modal("show"); 

        
        }else if(opval == "eliminar") {
            $('#eliminar-id_objetivo').val(opcion[1]);
            $('#eliminarModal').modal("show"); 
        

        }else if(opval == "comentar") {
            $('#comentar-id_objetivo').val(opcion[1]);
            $('#comentarModal').modal("show"); 
        }

        $(this).val("seleccionar");
    });
</script>



<!-- Modal EDITAR -->
<div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Objetivo</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?=URL?>tablero/editar" onsubmit="$('#fecha_vencimientoE').removeAttr('disabled')" id="form_editar">
          <div class="form-group">
            <label>Titulo</label>
            <input type="text" class="form-control" id="tituloE" name="titulo">
            <div class="invalid-feedback">Ingresa un título válido</div>
          </div>
          <div class="form-group">
            <label>Descripcion</label>
            <textarea class="form-control" name="descripcion" id="descripcionE" rows="2"></textarea>
            <div class="invalid-feedback">Ingresa una descripción válida</div>
          </div>
          <div class="form-group">
            <label>Dias de duración</label>
            <input type="number" class="form-control" min="1" id="dias_duracionE" step="1" name="dias" onchange="getFechaVencimiento('E');">
            <div class="invalid-feedback">Ingresa un valor válido</div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>Fecha Inicio</label>
                <input type="date" value="<?=date("Y-m-d")?>" id="fecha_inicioE" name="fecha_inicio" class="form-control" onchange="getFechaVencimiento('E');">
                <div class="invalid-feedback">Ingresa una fecha válida</div>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Fecha Vencimiento</label>
                <input type="date" class="form-control" id="fecha_vencimientoE" name="fecha_vencimiento" disabled>
                <div class="invalid-feedback">Ingresa una fecha válida</div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Prioridad</label>
            <select class="custom-select form-control" name="prioridad" id="editar-prioridad">
              <option value="baja">Baja</option>
              <option value="media">Media</option>
              <option value="alta">Alta</option>
            </select>
            <div class="invalid-feedback">Ingresa un valor válido</div>
          </div>
          <input type="hidden" id="editar-id_objetivo" name="id_objetivo">
      </div>
      <input type="hidden" name="de_equipo" value="ea">
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" type="button" onclick="validarEditar()">Aceptar</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Eliminar Modal-->
<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmar acción</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form method="post" action="<?=URL?>tablero/eliminar">
      <div class="modal-body">
        ¿Estas seguro de eliminar el objetivo?
        <input type="hidden" id="eliminar-id_objetivo" name="id_objetivo">
        <input type="hidden" name="de_equipo" value="ea">
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" type="submit" >Aceptar</button>
      </div>
    </form>
    </div>
  </div>
</div>


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
        <form method="post" action="<?=URL?>tablero/comentar" enctype="multipart/form-data" id="form_comentar">
          
          <div class="form-group">
            <label>Comentario</label>
            <textarea class="form-control" name="comentario" rows="2"></textarea>
          </div>

          <div class="form-group">
            <label for="archivo">Cargar archivo (opcional)</label>
            <input type="file" class="form-control-file" id="archivo" name="archivo" accept="application/pdf, .doc, .docx, .xlsx, .xls">
          </div>

          <input type="hidden" id="comentar-id_objetivo" name="id_objetivo">
          <input type="hidden" name="equipo" value="simon">

      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" type="button" onclick="validarComentario()">Aceptar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- FOR THE CALENDAR -->
<script src="<?=URL?>Views/template/js/moment.min.js"></script>

<script>

  function getFechaVencimiento(t = ''){
    var fi = '#fecha_inicio' + t;
    var dd = '#dias_duracion' + t;
    var fv = '#fecha_vencimiento' + t;
    var fecha_inicio = new Date( $(fi).val() );
    var dias = parseInt( $(dd).val() ) + fecha_inicio.getDate() + 1;
    var fecha_vencimiento = new Date(fecha_inicio.getFullYear(), fecha_inicio.getMonth(), dias);
    var mes = parseInt(fecha_vencimiento.getMonth()) + 1;
    var messtr = (mes>9) ? mes : '0' + mes;
    var diasstr = (parseInt(fecha_vencimiento.getDate())>9) ? fecha_vencimiento.getDate() : '0' + fecha_vencimiento.getDate();
    var fecha = fecha_vencimiento.getFullYear() + '-' + messtr + '-' + diasstr;
    $(fv).val(fecha);
  }

  function validarComentario(){
    var validado = true;
    // VALIDAR comentario
    if ( $('#comentario').val() == '' || $('#comentario').val().length < 5) {
        $('#comentario').addClass('is-invalid');
        validado = false;
    }else{
       $('#comentario').removeClass('is-invalid');
    }
    
    // SI TODO ESTA BIEN SUMBITEAT EL FORMULARIO
    if (validado) {
        $('#form_comentar').submit();
    }
  }


  function validarEditar(){
    var validado = true;
    var elementos = new Array();
    var selects = new Array();
    elementos.push('#tituloE');
    elementos.push('#descripcionE');
    
    selects.push('#editar-prioridad');

    // VALIDACION DE INPUT TEXT
    for (var i = 0; i < elementos.length ; i++) {
      if ( $(elementos[i]).val() == '' || $(elementos[i]).val().length < 5) {
          $(elementos[i]).addClass('is-invalid');
          validado = false;
      }else{
         $(elementos[i]).removeClass('is-invalid');
      }
    }

    // VALIDACION DE SELECT
    for (var i = 0; i < selects.length ; i++) {
      if ( $(selects[i]).val().length == 0) {
          $(selects[i]).addClass('is-invalid');
          validado = false;
      }else{
         $(selects[i]).removeClass('is-invalid');
      }
    }

    // VALIDACION DIAS DE DURACION
    if ( $('#dias_duracionE').val() < 1 ) {
        $("#dias_duracionE").addClass('is-invalid');
        validado = false;
    }else{
        $("#dias_duracionE").removeClass('is-invalid');
    }

    // VALIDACION DE FECHAININCIO
    var fecha_inicio = moment(  $("#fecha_inicioE").val()  ); 
    if (!fecha_inicio.isValid()) {
        $("#fecha_inicioE").addClass('is-invalid');
        validado = false;
    }else{
        $("#fecha_inicioE").removeClass('is-invalid');
    }

    // VALIDACION DE FECHAININCIO
    var fecha_vencimiento = moment(  $("#fecha_vencimientoE").val()  ); 
    if (!fecha_vencimiento.isValid()) {
        $("#fecha_vencimientoE").addClass('is-invalid');
        validado = false;
    }else{
        $("#fecha_vencimientoE").removeClass('is-invalid');
    }

    // SI TODO ESTA BIEN SUMBITEAT EL FORMULARIO
    if (validado) {
        $('#form_editar').submit();
    }

  }

</script>