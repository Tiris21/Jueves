<!-- ESTILO PARA UTILIZAR EL RANGEN PARA AVANZAR -->
<link rel="stylesheet" href="<?=URL?>Views/template/css/jquery-ui.min.css">

  <div class="content-wrapper">
    <div class="container-fluid">
      
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?=URL?>Home">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?=URL?>Tablero">Tablero</a>
        </li>
        <li class="breadcrumb-item active">Ver Objetivo</li>
      </ol>
      
      <div class="row">
        <div class="col-8">
          <h1> <i class="fa fa-fw fa-bullseye"></i> Detalle Del Objetivo</h1>
          <!-- <p>This is an example of a blank page that you can use as a starting point for creating new ones.</p> -->
        </div>

        <div class="col-4 text-right">
        <?php if ($obj['responsable'] == $_SESSION['id_usuario'] || $puede_ver == 'eaaaa'){ // SEGURIDAD MAXIMA PAPU ?>
        <!-- ES EL RESPONSABLE + USUARIOS DE NIVEL ARRIBA DEL RESPOSNSABLE -->
            <a class="btn btn-outline-secondary" data-toggle="modal" role="button" aria-pressed="true" href="#" data-target="#comentarModal"> 
              <i class="fa fa-fw fa-comment"></i> Comentar </a>
        <?php } ?>


        <?php if ($obj['responsable'] == $_SESSION['id_usuario']){ // SEGURIDAD MAXIMA PAPU ?>
          <?php if ($obj['tipo_avance'] != 'asignado'){ ?>
            <a class="btn btn-outline-primary" data-toggle="modal" role="button" aria-pressed="true" href="#" data-target="#avanzarModal"> 
              <i class="fa fa-fw fa-arrow-up"></i> Avanzar </a>
          <?php }?>
          <?php if ($_SESSION['permiso'] > 0){ ?>
            <a class="btn btn-outline-danger" data-toggle="modal" role="button" aria-pressed="true" href="#" data-target="#asignarModal">
              <i class="fa fa-fw fa-support"></i> Asignar </a>
          <?php } ?>
        <?php } ?>
        </div>

      </div>


      <div class="row">
        <div class="col-12">

          <!-- BODY CARD -->
          <div class="card carta border-<?=$c?>">
            <div class="card-block card-body ">
              <div>
                <h4 class="card-title text-<?=$c?>"> <?=$obj['titulo']?>  <?=($obj['tipo_avance'] == 'asignado') ? '<i class="fa fa-fw fa-support pull-right"></i>' : '' ?> </h4> 
              </div>
              <p class="card-text"> <?=$obj['descripcion']?> </p>
            <?php if ($objetivo_padre) { ?>
                <p class="card-text"> <strong>Objetivo Padre: </strong> <?= $objetivo_padre['titulo']?> </p>
            <?php } ?>
              <p class="card-text"> <strong>Responsable: </strong> <?=$obj['nombre']?> </p>
              <p class="card-text"> <strong>Prioridad: </strong> <?=ucwords($obj['prioridad'])?> </p>
              <div class="row"> 
                <span class="col-lg-2 col-sm-4"> <strong>Porcentaje de Avance: </strong> </span>
                <div class="progress col-lg-10 col-sm-8 pl-0 mt-1">  <?=($obj['avance'] == '0') ? '0%' : ''?>
                  <div class="progress-bar progress-bar-striped bg-<?=$c?>" role="progressbar" style="width: <?=$obj['avance']?>%" aria-valuenow="<?=$obj['avance']?>" aria-valuemin="0" aria-valuemax="100"><?=$obj['avance']?> %</div>
                </div>
              </div> 
            </div>
            <!--  FOOTER CARD -->
            <div class="card-footer bg-<?=$c?> text-white">
                <i>  Fecha Vencimiento: <?=formatearFecha($obj['fecha_vencimiento'])?>  </i>                
            </div>          
          </div> <!-- /card -->

        </div>
      </div>

<?php if($asignados->num_rows > 0) { ?>
      <div class="row">
         <div class="col-lg-12">

            <div class="card mb-3">
              <div class="card-header">
                <i class="fa fa-tasks"></i> Subobjetivos
              </div>
              <div class="card-body">
                <div class="row">
                  
                  <?php foreach ($asignados as $asig) { $c = getColorPorPorcentaje($asig['avance'], $asig['dias'], $asig['fecha_vencimiento']);?>
                  
                    <div class="col-lg-6">
                      <div class="card carta border-<?=$c?>">
                        <div class="card-block card-body ">
                          <div>
                            <h4 class="card-title text-<?=$c?>"> <?=$asig['titulo']?>  <?=($asig['tipo_avance'] == 'asignado') ? '<i class="fa fa-fw fa-support pull-right"></i>' : '' ?> </h4> 
                          </div>
                          <p class="card-text"> <?=$asig['descripcion']?> </p>
                          <p class="card-text"> <strong>Responsable: </strong> <?=$asig['nombre']?> </p>
                          <div class="row"> 
                            <span class="col-lg-2 col-sm-4"> <strong> Avance: </strong> </span>
                            <div class="progress col-lg-10 col-sm-8 pl-0 mt-1">  <?=($asig['avance'] == '0') ? '0%' : ''?>
                              <div class="progress-bar progress-bar-striped bg-<?=$c?>" role="progressbar" style="width: <?=$asig['avance']?>%" aria-valuenow="<?=$asig['avance']?>" aria-valuemin="0" aria-valuemax="100"><?=$asig['avance']?> %</div>
                            </div>
                          </div> 
                        </div>
                        <!--  FOOTER CARD -->
                        <div class="card-footer bg-<?=$c?> text-white">
                            <i>  Fecha Vencimiento: <?=formatearFecha($asig['fecha_vencimiento'])?>  </i>
                            <div class="pull-right">
                              <a class="btn btn-outline-light btn-card btn-card-<?=$c?>" href="<?=URL?>Objetivos/Ver/<?=$asig['id_objetivo']?>"> 
                                  <i class="fa fa-fw fa-eye"></i> Ver Detalle 
                              </a>
                            </div>
                        </div>          
                      </div> <!-- /card -->
                    </div>

                  <?php } ?>

                </div>
              </div>
              <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
            </div> <!-- card obj asignados -->
        </div>
      </div>
<?php } ?>

      <div class="row">
        <div class="col-12">

            <div class="card mb-3">
  
              <div class="card-header">
                <i class="fa fa-history"></i> Bitácora de Objetivo
              </div>
              
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-2"></div>
                  <div class="col-lg-8">

                    <ul class="timeline">
                      
                      <?php $type = '';
                      foreach ($acciones as $a) { 
                        switch ($a['clase']) {
                          case 'crear': ?>
                              <li class="<?=$type?>">
                                  <div class="timeline-badge success">
                                    <i class="fa fa-asterisk"></i>
                                  </div>
                                  <div class="timeline-panel">
                                      <div class="timeline-heading">
                                          <h4 class="timeline-title">Creación del objetivo</h4>
                                          <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?= formatearFechaHora($a['fecha_creacion']) ?> </small></p>
                                      </div>
                                      <!-- <div class="timeline-body">
                                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
                                      </div> -->
                                  </div>
                              </li>

                      <?php break;
                          case 'apropiar': ?>
                              <li class="<?=$type?>">
                                  <div class="timeline-badge warning">
                                    <i class="fa fa-magic"></i>
                                  </div>
                                  <div class="timeline-panel">
                                      <div class="timeline-heading">
                                          <h4 class="timeline-title">Apropación</h4>
                                          <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?= formatearFechaHora($a['fecha_creacion']) ?> </small></p>
                                      </div>
                                      <div class="timeline-body">
                                          <p> Objetivo asignado por <i><?=$nombre_usuario?></i>  </p>
                                      </div>
                                  </div>
                              </li>

                      <?php break;
                          case 'avanzar': ?>
                              <li class="<?=$type?>">
                                  <div class="timeline-badge primary">
                                    <i class="fa fa-arrow-up"></i>
                                  </div>
                                  <div class="timeline-panel">
                                      <div class="timeline-heading">
                                          <h4 class="timeline-title">Avance</h4>
                                          <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?= formatearFechaHora($a['fecha_creacion']) ?> </small></p>
                                      </div>
                                      <div class="timeline-body">
                                          <p> Se avanzó del <?=$a['aux1']?>% al <?=$a['aux2']?>%  </p>
                                    <?php if ($a['comentario'] != ''){ ?>  
                                          <p> El avance contiene un comentario: </p>
                                          <p>"<i><?=$a['comentario']?></i>"</p>
                                    <?php } ?>
                                      </div>
                                  </div>
                              </li>

                      <?php break;
                          case 'asignar': ?>
                              <li class="<?=$type?>">
                                  <div class="timeline-badge danger">
                                    <i class="fa fa-support"></i>
                                  </div>
                                  <div class="timeline-panel">
                                      <div class="timeline-heading">
                                          <h4 class="timeline-title">Asignación</h4>
                                          <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?= formatearFechaHora($a['fecha_creacion']) ?> </small></p>
                                      </div>
                                    <?php if ($a['comentario'] != ''){ ?>  
                                      <div class="timeline-body">
                                          <p> La asignación contiene un comentario: </p>
                                          <p>"<i><?=$a['comentario']?></i>"</p>
                                      </div>
                                    <?php } ?>
                                  </div>
                              </li>

                      <?php break;
                          case 'comentar': ?>
                              <li class="<?=$type?>">
                                  <div class="timeline-badge secondary">
                                    <i class="fa fa-comment"></i>
                                  </div>
                                  <div class="timeline-panel">
                                      <div class="timeline-heading">
                                          <h4 class="timeline-title">Comentario</h4>
                                          <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?= formatearFechaHora($a['fecha_creacion']) ?> </small></p>
                                      </div>
                                      <div class="timeline-body">
                                    <?php if ($a['comentario'] != ''){ ?>                                            
                                          <p>"<i><?=$a['comentario']?></i>"</p>
                                    <?php } ?>
                                    <?php if ($a['aux1'] != ''){ ?>                                            
                                          <p>El comentario lleva un archivo adjunto <a href="<?=URL?>Objetivos/descargar/<?=$a['aux1']?>" ><?=$a['aux1']?></a></p>
                                    <?php } ?>
                                      </div>
                                  </div>
                              </li>

                      <?php
                          break; 
                        default:
                            echo '';
                            break;
                        } ?>

                      <?php $type = ($type == '') ? 'timeline-inverted' : '';
                      } ?>

                     <!--  <li class="timeline-inverted">
                          <div class="timeline-badge warning">
                            <i class="fa fa-credit-card"></i>
                          </div>

                          <div class="timeline-panel">
                              <div class="timeline-heading">
                                  <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                  <p><small class="text-muted"><i class="fa fa-clock-o"></i> 11 hours ago via Twitter</small></p>
                              </div>
                              <div class="timeline-body">
                                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem dolorem quibusdam, tenetur commodi provident cumque magni voluptatem libero, quis rerum. Fugiat esse debitis optio, tempore. Animi officiis alias, officia repellendus.</p>
                                  <hr>
                                  <div class="btn-group">
                                      <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                          <i class="fa fa-gear"></i> <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu" role="menu">
                                          <li><a href="#">Action</a>
                                          </li>
                                          <li><a href="#">Another action</a>
                                          </li>
                                          <li><a href="#">Something else here</a>
                                          </li>
                                          <li class="divider"></li>
                                          <li><a href="#">Separated link</a>
                                          </li>
                                      </ul>
                                  </div>
                              </div>
                          </div>
                      </li> -->

                  </ul>

                  </div>
                </div>
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
          <form method="post" action="<?=URL?>Objetivos/comentar" enctype="multipart/form-data" id="form_comentar">
            
            <div class="form-group">
              <label>Comentario</label>
              <textarea class="form-control" name="comentario" rows="2" id="comentario"></textarea>
              <div class="invalid-feedback">Ingresa un valor válido</div>
            </div>

            <div class="form-group">
              <label for="archivo">Cargar archivo (opcional)</label>
              <input type="file" class="form-control-file" id="archivo" name="archivo" accept="application/pdf, .doc, .docx, .xlsx, .xls">
            </div>

            <input type="hidden" id="comentar-id_objetivo" name="id_objetivo" value="<?=$obj['id_objetivo']?>">

        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" type="button" onclick="validarComentario()">Aceptar</button>
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
            <form method="post" action="<?=URL?>Objetivos/avanzar" id="form_avance">
              <div class="form-group">
                <label>Porcentaje de Avance</label>
                <div id="slider" class="mr-3">
                  <div id="porcentaje-handler" class="ui-slider-handle"></div>
                </div>
                <small class="form-text text-danger" id="error_slider" style="display: none">Ingresa un valor mayor al anterior</small>
                <input type="hidden" id="avance_anterior" name="avance_anterior" value="<?=$obj['avance']?>">
                <input type="hidden" id="avanzar-porcentaje" name="porcentaje_avance">
              </div>

              <div class="form-group">
                <label>Comentario de avance</label>
                <textarea class="form-control" name="comentario_avance" rows="2"></textarea>
              </div>
              <input type="hidden" id="avanzar-id_objetivo" name="id_objetivo" value="<?=$obj['id_objetivo']?>">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary" type="button" onclick="validarAvance()">Aceptar</button>
            </form>
          </div>
        </div>
      </div>
    </div>




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
                <input type="text" class="form-control" id="tituloA" name="titulo" value="<?=$obj['titulo']?>">
                <div class="invalid-feedback">Ingresa un título válido</div>
              </div>
              <div class="form-group">
                <label>Descripcion</label>
                <textarea class="form-control" name="descripcion" id="descripcionA" rows="2"><?=$obj['descripcion']?></textarea>
                <div class="invalid-feedback">Ingresa una descripción válida</div>
              </div>
              <div class="form-group">
                <label>Dias de duración</label>
                <input type="number" class="form-control" min="1" id="dias_duracionA" step="1" name="dias" value="<?=$obj['dias']?>" onchange="getFechaVencimiento('A');">
                <div class="invalid-feedback">Ingresa un valor válido</div>
                <input type="hidden" id="dias_duracion_padre" value="<?=$obj['dias']?>">
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Fecha Inicio</label>
                    <input type="date" value="<?=str_replace(' 00:00:00', '', $obj['fecha_asignacion'])?>" id="fecha_inicioA" name="fecha_inicio" class="form-control" onchange="getFechaVencimiento('A');">
                    <div class="invalid-feedback">Ingresa una fecha válida</div>
                    <input type="hidden" id="fecha_inicio_padre" value="<?=str_replace(' 00:00:00', '', $obj['fecha_asignacion'])?>">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Fecha Vencimiento</label>
                    <input type="date" class="form-control" id="fecha_vencimientoA" name="fecha_vencimiento" value="<?=str_replace(' 00:00:00', '', $obj['fecha_vencimiento'])?>" disabled>
                    <div class="invalid-feedback">Ingresa una fecha válida</div>
                    <input type="hidden" id="fecha_vencimiento_padre" value="<?=str_replace(' 00:00:00', '', $obj['fecha_vencimiento'])?>">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Comentario de asignación (opcional)</label>
                <textarea class="form-control" name="comentario_asignacion" rows="2"></textarea>
              </div>
              <input type="hidden" id="asignar-id_objetivo" value="<?=$obj['id_objetivo']?>" name="id_objetivo">
              <input type="hidden" name="de_ver" value="<?=$obj['id_objetivo']?>">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary" type="button" onclick="validarAsignar()">Aceptar</button>
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
            <p> <strong> Se te redericcionará a la pagina de tú equipo </strong> </p>
            <p class="text-center text-danger" style="font-size: 12em;"> <i class="fa fa-ban" aria-hidden="true"></i> </p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>




<!-- FOR THE RANGE INPUT (AVANZAR) -->
<script src="<?=URL?>Views/template/js/jquery-ui.min.js"></script>
<!-- FOR THE VALIDAR FECHA -->
<script src="<?=URL?>Views/template/js/moment.min.js"></script>

<script>

    $(document).ready(function() {
      if ("<?=$puede_ver?>" == "nel" && "<?=$_SESSION['id_usuario']?>" != "<?=$obj['responsable']?>") {
        $('#advertenciaModal').on('hidden.bs.modal', function (e) {
            window.location.href = "<?=URL?>Tablero";
        })
        $('#advertenciaModal').modal("show"); 
      }
    });



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

      $('#avanzar-porcentaje').val(<?=$obj['avance']?>);
      $( "#slider" ).slider( "value", <?=$obj['avance']?> );
      $( "#porcentaje-handler" ).text( <?=$obj['avance']?> );

    });
    

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


    function validarAvance(){
      var validado = true;
      // VALIDAR slider
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
    if (fecha_vencimiento > fecha_vencimiento_padre || !fecha_vencimiento.isValid() ) {
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

</script>