<!-- ESTILO PARA UTILIZAR EL RANGEN PARA AVANZAR -->
<link rel="stylesheet" href="<?=URL?>Views/template/css/jquery-ui.min.css">

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?=URL?>">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Tablero</li>
      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-9">
          <h1> <i class="fa fa-fw fa-table"></i> Mi Tablero de Control</h1>  <!-- (< ?=$_SESSION['nombre']?>) -->
        </div>
      <?php if ($_SESSION['permiso'] > 0) {?>
        <div class="col-3 text-right">
          <a class="btn btn-outline-info" data-toggle="modal" role="button" aria-pressed="true" href="#" data-target="#nuevoModal"> 
            <i class="fa fa-fw fa-plus"></i> Nuevo </a>
        </div>
      <?php } ?>
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
                  <th>Priorirdad</th>
                  <th>T.A.</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>

              <?php setlocale(LC_TIME,"es_MX");
                foreach ($mis_objetivos as $obj) {
                  $c = getColorPorPorcentaje($obj['avance'], $obj['dias'],  $obj['fecha_vencimiento']);
              ?>
                <tr>
                  <td> <?= $obj['titulo'] ?> </td>
                  <td><?= formatearFecha($obj['fecha_asignacion']) ?></td>
                  <td><?= formatearFecha($obj['fecha_vencimiento']) ?></td>
                  <td><?= (difDiasAHoy($obj['fecha_vencimiento']) < 0) ? 0 : difDiasAHoy($obj['fecha_vencimiento']) ?> </td>
                  <td class="text-white bg-<?=$c?>"><?= $obj['avance'] ?>% </td>
                  <td><?= ucwords($obj['prioridad']) ?> </td>
                  <td> <h4> <?= ($obj['tipo_avance'] == 'asignado') ? '<i class="fa fa-fw fa-support text-danger"></i>' : '<i class="fa fa-fw fa-user text-secondary"></i>' ?></h4> </td>
                  <td>
                    <select class="custom-select acciones">
                      <option value="seleccionar" selected>Seleccionar..</option>
                      <option value="ver-<?=$obj['id_objetivo']?>">Ver Detalle</option>
                      <?php if ($obj['tipo_avance'] != 'asignado') {?>
                        <option value="avanzar-<?=$obj['id_objetivo']?>-<?=$obj['avance']?>">Avanzar</option>

                      <?php } if ($_SESSION['permiso'] > 0) {?>
                      <option value="asignar-<?=$obj['id_objetivo']?>">Asignar</option>
                      <?php } ?>
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
                $('#descripcionA').text(result.descripcion);
                $('#dias_duracionA').val(result.dias);
                $('#dias_duracion_padre').val(result.dias);
                var fa = result.fecha_asignacion.split(' ');
                $('#fecha_inicioA').val(fa[0]);
                $('#fecha_inicio_padre').val(fa[0]);
                fa = result.fecha_vencimiento.split(' ');
                $('#fecha_vencimientoA').val(fa[0]);
                $('#fecha_vencimiento_padre').val(fa[0]);
              }
            });
            $('#asignarModal').modal("show"); 


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


        }else if(opval == "avanzar") {
            $('#avanzar-id_objetivo').val(opcion[1]);
            $('#avanzar-porcentaje').val(opcion[2]);
            $('#avance_anterior').val(opcion[2]);
            $( "#slider" ).slider( "value", opcion[2] );
            $( "#porcentaje-handler" ).text(opcion[2]);
            $('#avanzarModal').modal("show"); 


        }else if(opval == "comentar") {
            $('#comentar-id_objetivo').val(opcion[1]);
            $('#comentarModal').modal("show"); 
        
        
        }else if(opval == "eliminar") {
            $('#eliminar-id_objetivo').val(opcion[1]);
            $('#eliminarModal').modal("show"); 
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
            <form method="post" action="<?=URL?>tablero/asignar" onsubmit="$('#fecha_vencimientoA').removeAttr('disabled')" id="form_asignar">
              <div class="form-group">
                <label>Responsable(s)</label>
                <select class="custom-select form-control" name="responsable[]" id="responsables" multiple>
                  <!-- <option selected>Seleccionar...</option> -->
                  <?php foreach ($mi_equipo as $usr) { ?>
                    <option value="<?=$usr['id_usuario']?>"><?=$usr['nombre']?></option>
                  <?php } ?>
                </select>
                <div class="invalid-feedback">Selecciona al menos un responsable</div>
              </div>
              <div class="form-group">
                <label>Titulo</label>
                <input type="text" class="form-control" id="tituloA" name="titulo">
                <div class="invalid-feedback">Ingresa un título válido</div>
              </div>
              <div class="form-group">
                <label>Descripcion</label>
                <textarea class="form-control" name="descripcion" id="descripcionA" rows="2"></textarea>
                <div class="invalid-feedback">Ingresa una descripción válida</div>
              </div>
              <div class="form-group">
                <label>Dias de duración</label>
                <input type="number" class="form-control" min="1" id="dias_duracionA" step="1" name="dias" onchange="getFechaVencimiento('A');">
                <div class="invalid-feedback">Ingresa un valor válido</div>
                <input type="hidden" id="dias_duracion_padre">
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Fecha Inicio</label>
                    <input type="date" value="<?=date("Y-m-d")?>" id="fecha_inicioA" name="fecha_inicio" class="form-control" onchange="getFechaVencimiento('A');">
                    <div class="invalid-feedback">Ingresa una fecha válida</div>
                    <input type="hidden" id="fecha_inicio_padre">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Fecha Vencimiento</label>
                    <input type="date" class="form-control" id="fecha_vencimientoA" name="fecha_vencimiento" disabled>
                    <div class="invalid-feedback">Ingresa una fecha válida</div>
                    <input type="hidden" id="fecha_vencimiento_padre">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Comentario de asignación (opcional)</label>
                <textarea class="form-control" name="comentario_asignacion" rows="2"></textarea>
              </div>
              <input type="hidden" id="asignar-id_objetivo" name="id_objetivo">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary" type="button" onclick="validarAsignar()">Aceptar</button>
            </form>
          </div>
        </div>
      </div>
    </div>


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
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary" type="button" onclick="validarEditar()">Aceptar</button>
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
            <form method="post" action="<?=URL?>tablero/avanzar" id="form_avance">
              <div class="form-group">
                <label>Porcentaje de Avance</label>
                <div id="slider" class="mr-3">
                  <div id="porcentaje-handler" class="ui-slider-handle"></div>
                </div>
                <small class="form-text text-danger" id="error_slider" style="display: none">Ingresa un valor mayor al anterior</small>
                <input type="hidden" id="avanzar-porcentaje" name="porcentaje_avance">
                <input type="hidden" id="avance_anterior" name="avance_anterior">
              </div>

              <div class="form-group">
                <label>Comentario de avance</label>
                <textarea class="form-control" name="comentario_avance" rows="2"></textarea>
              </div>
              <input type="hidden" id="avanzar-id_objetivo" name="id_objetivo">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary" type="button" onclick="validarAvance()">Aceptar</button>
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
            <form method="post" action="<?=URL?>tablero/comentar" enctype="multipart/form-data" id="form_comentar">
              
              <div class="form-group">
                <label>Comentario</label>
                <textarea class="form-control" name="comentario" id="comentario" rows="2"></textarea>
                <div class="invalid-feedback">Ingresa una fecha válida</div>
              </div>

              <div class="form-group">
                <label for="archivo">Cargar archivo (opcional)</label>
                <input type="file" class="form-control-file" id="archivo" name="archivo" accept="application/pdf, .doc, .docx, .xlsx, .xls">
              </div>

              <input type="hidden" id="comentar-id_objetivo" name="id_objetivo">

          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary" type="button" onclick="validarComentario()">Aceptar</button>
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
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary" type="submit" >Aceptar</button>
          </div>
        </form>
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
            <form method="post" action="<?=URL?>tablero/crear" onsubmit="$('#fecha_vencimiento').removeAttr('disabled')" id="form_nuevo">
              <div class="form-group">
                <label for="exampleInputEmail1">Título</label>
                <input type="text" class="form-control" name="titulo" id="titulo">
                <div class="invalid-feedback">Ingresa un título válido</div>
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
              </div>
              <div class="form-group">
                <label>Descripción</label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="2"></textarea>
                <div class="invalid-feedback">Ingresa una descripción válida</div>
              </div>
              <div class="form-group">
                <label>Dias de duración</label>
                <input type="number" class="form-control" min="1" id="dias_duracion" step="1" name="dias" onchange="getFechaVencimiento();">
                <div class="invalid-feedback">Ingresa un valor válido</div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Fecha Inicio</label>
                    <input type="date" value="<?=date("Y-m-d")?>" id="fecha_inicio" name="fecha_inicio" class="form-control" onchange="getFechaVencimiento();">
                    <div class="invalid-feedback">Ingresa un fecha válida</div>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Fecha Vencimiento</label>
                    <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" disabled>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Prioridad</label>
                <select class="custom-select form-control" name="prioridad" id="prioridad">
                  <option value="baja">Baja</option>
                  <option value="media">Media</option>
                  <option value="alta">Alta</option>
                </select>
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
            <button class="btn btn-primary" type="button" onclick="validarNuevoObjetivo()">Guardar</button>
            </form>
          </div>
        </div>
      </div>
    </div>

<!-- FOR THE RANGE INPUT (AVANZAR) -->
<script src="<?=URL?>Views/template/js/jquery-ui.min.js"></script>
<!-- FOR THE CALENDAR -->
<script src="<?=URL?>Views/template/js/moment.min.js"></script>

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
        $('#avanzar-porcentaje').val(ui.value);
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



  function validarNuevoObjetivo(){
    var elementos = new Array();
    var validado = true;

    elementos.push('#titulo');
    elementos.push('#descripcion');

    // VALIDACION DE TITULO, DESCRIPCION
    for (var i = 0; i < elementos.length ; i++) {
      if ( $(elementos[i]).val() == '' || $(elementos[i]).val().length < 5) {
          $(elementos[i]).addClass('is-invalid');
          validado = false;
      }else{
         $(elementos[i]).removeClass('is-invalid');
      }
    }

    // VALIDACION DE FECHAININCIO
    var fecha_inicio = moment(  $("#fecha_inicio").val()  ); 
    if (!fecha_inicio.isValid()) {
        $("#fecha_inicio").addClass('is-invalid');
        validado = false;
    }else{
        $("#fecha_inicio").removeClass('is-invalid');
    }

    // VALIDACION DIA MES
    if ( $('#dia_mensual').val() < 1 || $('#dia_mensual').val() > 365 ) {
        $("#dia_mensual").addClass('is-invalid');
        validado = false;
    }else{
        $("#dia_mensual").removeClass('is-invalid');
    }
    
    // SI TODO ESTA BIEN SUMBITEAT EL FORMULARIO
    if (validado) {
        $('#form_nuevo').submit();
    }
  
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

  function validarAvance(){
    var validado = true;
    if ( parseInt($('#avanzar-porcentaje').val()) <= parseInt($('#avance_anterior').val())  ) {
        $("#error_slider").css('display', 'inline');
        validado = false;
    }else{
        $("#error_slider").css('display', 'none');
    }
    
    // SI TODO ESTA BIEN SUMBITEAT EL FORMULARIO
    if (validado) {
        $('#form_avance').submit();
    }
  }


  function validarAsignar(){
    var validado = true;
    var elementos = new Array();
    var selects = new Array();
    elementos.push('#tituloA');
    elementos.push('#descripcionA');
    
    selects.push('#responsables');

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
    if ( $('#dias_duracionA').val() < 1 || parseInt($('#dias_duracionA').val()) > parseInt($('#dias_duracion_padre').val()) ) {
        $("#dias_duracionA").addClass('is-invalid');
        validado = false;
    }else{
        $("#dias_duracionA").removeClass('is-invalid');
    }

    // VALIDACION DE FECHAININCIO
    var fecha_inicio = moment(  $("#fecha_inicioA").val()  ); 
    var fecha_inicio_padre = moment( $("#fecha_inicio_padre").val() ); 
    if (fecha_inicio < fecha_inicio_padre || !fecha_inicio.isValid()) {
        $("#fecha_inicioA").addClass('is-invalid');
        validado = false;
    }else{
        $("#fecha_inicioA").removeClass('is-invalid');
    }

    // VALIDACION DE FECHAININCIO
    var fecha_vencimiento = moment(  $("#fecha_vencimientoA").val()  ); 
    var fecha_vencimiento_padre = moment( $("#fecha_vencimiento_padre").val() ); 
    if (fecha_vencimiento > fecha_vencimiento_padre || !fecha_vencimiento.isValid()) {
        $("#fecha_vencimientoA").addClass('is-invalid');
        validado = false;
    }else{
        $("#fecha_vencimientoA").removeClass('is-invalid');
    }

    // SI TODO ESTA BIEN SUMBITEAT EL FORMULARIO
    if (validado) {
        $('#form_asignar').submit();
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
