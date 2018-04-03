<!-- ESTILO PARA UTILIZAR EL RANGEN PARA AVANZAR -->
<link rel="stylesheet" href="<?=URL?>Views/template/css/jquery-ui.min.css">

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
          <h1> <i class="fa fa-fw fa-table"></i> Mi Tablero de Control</h1>  <!-- (< ?=$_SESSION['nombre']?>) -->
        </div>
        <div class="col-3 text-right">
          <a class="btn btn-outline-info" data-toggle="modal" role="button" aria-pressed="true" href="#" data-target="#nuevoModal"> 
            <i class="fa fa-fw fa-plus"></i> Nuevo </a>
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

              <?php setlocale(LC_TIME,"es_MX");
                foreach ($mis_objetivos as $obj) {
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
                      <?php if ($obj['tipo_avance'] != 'asignado') {?>
                        <option value="avanzar-<?=$obj['id_objetivo']?>-<?=$obj['avance']?>">Avanzar</option>
                      <?php } ?>
                      <?php if ($_SESSION['permiso'] > 0) {?>
                      <option value="asignar-<?=$obj['id_objetivo']?>">Asignar</option>
                      <?php } ?>
                      <option value="comentar-<?=$obj['id_objetivo']?>">Comentar</option>
                    </select>
                  </td>
                </tr>  
                 
              <?php 
                }
              ?>
                   
              <!-- 
                <tr>
                  <td>Reducir Venta Negada</td>
                  <td>01/Ene/2018</td>
                  <td>21/Marzo/2018</td>
                  <td> 21 </td>
                  <td class=" text-white bg-warning"> 30 % </td>
                  <td> <h4 class="text-danger"><i class="fa fa-fw fa-support"></i></h4> </td>
                  <td>
                    <select class="custom-select acciones">
                      <option value="seleccionar" selected>Seleccionar..</option>
                      <option value="ver">Ver Detalle</option>
                      <option value="avanzar">Avanzar</option>
                      <option value="asignar">Asignar</option>
                    </select>
                  </td>
                </tr>  
              -->

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
            // $.ajax({ 
            //   type: "post",
            //   url:  '<?=URL?>tablero/ajaxDetalleObjetivo', 
            //   data: {
            //         id_obj: opcion[1],
            //   },
            //   success: function(result){
            //     $('#ver-body').html(result);
            //     // console.log(result);
            //   }
            // });
            // $('#verModal').modal("show"); 
            window.location.href = "<?=URL?>Objetivos/ver/"+opcion[1];


        }else if(opval == "asignar") {
            $('#asignar-id_objetivo').val(opcion[1]);
            $.ajax({ 
              type: "post",
              url:  '<?=URL?>tablero/ajaxObjetivo', 
              dataType: 'json',
              data: {
                    id_obj: opcion[1],
              },
              success: function(result){
                $('#tituloA').val(result.titulo);
                $('#descripcionA').val(result.descripcion);
                $('#dias_duracionA').val(result.dias);
                var fa = result.fecha_asignacion.split(' ');
                $('#fecha_inicioA').val(fa[0]);
                fa = result.fecha_vencimiento.split(' ');
                $('#fecha_vencimientoA').val(fa[0]);
              }
            });
            $('#asignarModal').modal("show"); 


        }else if(opval == "avanzar") {
            $('#avanzar-id_objetivo').val(opcion[1]);
            $('#avanzar-porcentaje').val(opcion[2]);
            $( "#slider" ).slider( "value", opcion[2] );
            $( "#porcentaje-handler" ).text(opcion[2]);
            $('#avanzarModal').modal("show"); 


        }else if(opval == "comentar") {
            $('#comentar-id_objetivo').val(opcion[1]);
            $('#comentarModal').modal("show"); 
        }

        $(this).val("seleccionar");
    });

</script>

<!-- Modal ASIGNAR -->
    <div class="modal fade" id="asignarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Asignar Objetivo</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" action="<?=URL?>tablero/asignar" onsubmit="$('#fecha_vencimientoA').removeAttr('disabled')">
              <div class="form-group">
                <label>Responsable(s)</label>
                <select class="custom-select form-control" name="responsable[]" multiple>
                  <!-- <option selected>Seleccionar...</option> -->
                  <?php foreach ($mi_equipo as $usr) { ?>
                    <option value="<?=$usr['id_usuario']?>"><?=$usr['nombre']?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Titulo</label>
                <input type="text" class="form-control" id="tituloA" name="titulo">
              </div>
              <div class="form-group">
                <label>Descripcion</label>
                <textarea class="form-control" name="descripcion" id="descripcionA" rows="2"></textarea>
              </div>
              <div class="form-group">
                <label>Dias de duración</label>
                <input type="number" class="form-control" min="1" id="dias_duracionA" step="1" name="dias" onchange="getFechaVencimiento('A');">
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Fecha Inicio</label>
                    <input type="date" value="<?=date("Y-m-d")?>" id="fecha_inicioA" name="fecha_inicio" class="form-control" onchange="getFechaVencimiento('A');">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Fecha Vencimiento</label>
                    <input type="date" class="form-control" id="fecha_vencimientoA" name="fecha_vencimiento" disabled>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Comentario de asignación</label>
                <textarea class="form-control" name="comentario_asignacion" rows="2"></textarea>
              </div>
              <input type="hidden" id="asignar-id_objetivo" name="id_objetivo">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary" type="submit">Aceptar</button>
            </form>
          </div>
        </div>
      </div>
    </div>



    <!-- Modal AVANZAR -->
    <div class="modal fade" id="avanzarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Avanzar Objetivo</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" action="<?=URL?>tablero/avanzar">
              <div class="form-group">
                <label>Porcentaje de Avance</label>
                <div id="slider" class="mr-3">
                  <div id="porcentaje-handler" class="ui-slider-handle"></div>
                </div>
                <input type="hidden" id="avanzar-porcentaje" name="porcentaje_avance">
              </div>

              <div class="form-group">
                <label>Comentario de avance</label>
                <textarea class="form-control" name="comentario_avance" rows="2"></textarea>
              </div>
              <input type="hidden" id="avanzar-id_objetivo" name="id_objetivo">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary" type="submit">Aceptar</button>
            </form>
          </div>
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
            <form method="post" action="<?=URL?>tablero/comentar" enctype="multipart/form-data">
              
              <div class="form-group">
                <label>Comentario</label>
                <textarea class="form-control" name="comentario" rows="2"></textarea>
              </div>

              <div class="form-group">
                <label>Cargar archivo (opcional)</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="customFileLang" name="archivo" lang="es" accept="application/pdf, .doc, .docx, .xlsx, .xls">
                  <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                </div>
              </div>
              <input type="hidden" id="comentar-id_objetivo" name="id_objetivo">

          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary" type="submit">Aceptar</button>
            </form>
          </div>
        </div>
      </div>
    </div>



    <!-- Modal VER -->
    <div class="modal fade" id="verModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detalles de Objetivo</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" id="ver-body">
            <!-- carta -->
            <!-- /card -->
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" type="button" data-dismiss="modal">Aceptar</button>
          </div>
        </div>
      </div>
    </div>



    <!-- Nuevo Modal-->
    <div class="modal fade" id="nuevoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Crear Objetivo</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" action="<?=URL?>tablero/crear" onsubmit="$('#fecha_vencimiento').removeAttr('disabled')">
              <div class="form-group">
                <label for="exampleInputEmail1">Titulo</label>
                <input type="text" class="form-control" name="titulo">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
              </div>
              <div class="form-group">
                <label>Descripcion</label>
                <textarea class="form-control" name="descripcion" rows="2"></textarea>
              </div>
              <div class="form-group">
                <label>Dias de duración</label>
                <input type="number" class="form-control" min="1" id="dias_duracion" step="1" name="dias" onchange="getFechaVencimiento();">
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Fecha Inicio</label>
                    <input type="date" value="<?=date("Y-m-d")?>" id="fecha_inicio" name="fecha_inicio" class="form-control" onchange="getFechaVencimiento();">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Fecha Vencimiento</label>
                    <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" disabled>
                  </div>
                </div>
              </div>
              <!-- <div class="form-group">
                <label for="exampleInputPassword1">Responsable</label>
                <select class="custom-select form-control" name="responsable">
                  <option selected>Seleccionar...</option>
                  <option value="<?=$_SESSION['id_usuario']?>">Yo</option>
                  <?php foreach ($mi_equipo as $usr) { ?>
                    <option value="<?=$usr['id_usuario']?>"><?=$usr['nombre']?></option>
                  <?php } ?>
                </select>
              </div> -->
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary" type="submit">Guardar</button>
            </form>
          </div>
        </div>
      </div>
    </div>

<!-- FOR THE RANGE INPUT (AVANZAR) -->
<script src="<?=URL?>Views/template/js/jquery-ui.min.js"></script>

<script>
  $( function() {
    var handle = $( "#porcentaje-handler" );
    $( "#slider" ).slider({
      animate: true,
      range: "min",
      create: function() {
        handle.text( $( this ).slider( "value" ) );
      },
      slide: function( event, ui ) {
        handle.text( ui.value );
        $('#avanzar-porcentaje').val(ui.value)
      }
    });
  } );

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

</script>
