<!-- ESTILO PARA UTILIZAR EL RANGEN PARA AVANZAR -->
<link rel="stylesheet" href="<?=URL?>Views/template/css/jquery-ui.min.css">

  <div class="content-wrapper">
    <div class="container-fluid">
      
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="Home">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Ver Objetivo</li>
      </ol>
      
      <div class="row">
        <div class="col-8">
          <h1> <i class="fa fa-fw fa-bullseye"></i> Detalle Del Objetivo</h1>
          <!-- <p>This is an example of a blank page that you can use as a starting point for creating new ones.</p> -->
        </div>

        <?php if ($obj['responsable'] == $_SESSION['id_usuario']){ // SEGURIDAD MAXIMA PAPU?>
          <div class="col-4 text-right">
            <a class="btn btn-outline-secondary" data-toggle="modal" role="button" aria-pressed="true" href="#" data-target="#comentarModal"> 
              <i class="fa fa-fw fa-comment"></i> Comentar </a>
            <?php if ($obj['tipo_avance'] != 'asignado'){ ?>
            <a class="btn btn-outline-primary" data-toggle="modal" role="button" aria-pressed="true" href="#" data-target="#avanzarModal"> 
              <i class="fa fa-fw fa-arrow-up"></i> Avanzar </a>
            <!-- <a class="btn btn-outline-danger" data-toggle="modal" role="button" aria-pressed="true" href="#" data-target="#avanzarModal"> 
              <i class="fa fa-fw fa-support"></i> Asignar </a> -->
            <?php }?>
          </div>
        <?php } ?>

      </div>


      <div class="row">
        <div class="col-12">

          <!-- BODY CARD -->
          <div class="card carta border-<?=$c?>">
            <div class="card-block card-body ">
              <div>
                <h4 class="card-title text-<?=$c?>"> <?=$obj['titulo']?>  <?=($obj['tipo_avance'] == 'asignado') ? '<i class="fa fa-fw fa-support pull-right"></i>' : '' ?> </h4> 
              </div>
              <p class="card-text"> <?=$obj['titulo']?> </p>
              <p class="card-text"> <strong>Responsable: </strong> <?=$obj['nombre']?> </p>
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
         <div class="col-12">

            <div class="card mb-3">
              <div class="card-header">
                <i class="fa fa-tasks"></i> Subobjetivos
              </div>
              <div class="card-body">
                <div class="row">
                  
                  <?php foreach ($asignados as $asig) { $c = getColorPorPorcentaje($asig['avance'])?>
                  
                    <div class="col-6">
                      <div class="card carta border-<?=$c?>">
                        <div class="card-block card-body ">
                          <div>
                            <h4 class="card-title text-<?=$c?>"> <?=$asig['titulo']?>  <?=($asig['tipo_avance'] == 'asignado') ? '<i class="fa fa-fw fa-support pull-right"></i>' : '' ?> </h4> 
                          </div>
                          <p class="card-text"> <?=$asig['titulo']?> </p>
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
          <form method="post" action="<?=URL?>Objetivos/comentar" enctype="multipart/form-data">
            
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
            <input type="hidden" id="comentar-id_objetivo" name="id_objetivo" value="<?=$obj['id_objetivo']?>">

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
            <form method="post" action="<?=URL?>Objetivos/avanzar">
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
              <input type="hidden" id="avanzar-id_objetivo" name="id_objetivo" value="<?=$obj['id_objetivo']?>">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary" type="submit">Aceptar</button>
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
        $('#avanzar-porcentaje').val(ui.value);
      }
    });

    $('#avanzar-porcentaje').val(<?=$obj['$avance']?>);
    $( "#slider" ).slider( "value", <?=$obj['$avance']?> );
    $( "#porcentaje-handler" ).text( <?=$obj['$avance']?> );
  } );
</script>