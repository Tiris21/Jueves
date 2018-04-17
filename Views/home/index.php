<div class="content-wrapper">
    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>

      <div class="row mb-3">
        <div class="col-12">
          <h1> <i class="fa fa-fw fa-dashboard"></i> Dashboard</h1>
          <!-- <p>This is an example of a blank page that you can use as a starting point for creating new ones.</p> -->
        </div> 
      </div>

      <!-- Icon Cards-->
      <div class="row">

        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-calendar-check-o"></i>
              </div>
              <div class="mr-5"> <span style="font-size: 40px"> <?= ($citas == '1') ? '1 </span> Cita Nueva</div>' : $citas.'</span> Citas Nuevas</div>' ?>
            </div>
            <a class="card-footer bg-light text-success clearfix small z-1" href="<?=URL?>Agenda">
              <span class="float-left">Ver Detalles</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-arrow-up"></i>
              </div>
              <div class="mr-5"> <span style="font-size: 40px"><?= ($avances == '1') ? '1 </span> Avance Nuevo </div>' : $avances.'</span> Avances Nuevos</div>' ?>
            </div>
            <a class="card-footer bg-light text-primary clearfix small z-1" href="<?=URL?>Tablero">
              <span class="float-left">Ver Detalles</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-secondary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-comment"></i>
              </div>
              <div class="mr-5"> <span style="font-size: 40px"> <?= ($comentarios == '1') ? '1 </span> Comentario Nuevo</div>' : $comentarios.'</span> Comentarios Nuevos</div>' ?>
            </div>
            <a class="card-footer bg-light text-secondary clearfix small z-1" href="<?=URL?>Tablero">
              <span class="float-left">Ver Detalles</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-support"></i>
              </div>
              <div class="mr-5"> <span style="font-size: 40px"> <?= ($asignaciones == '1') ? '1 </span> Asignacion Nueva</div>' : $asignaciones.'</span> Asignaciones Nuevas</div>' ?>
            </div>
            <a class="card-footer bg-light text-danger clearfix small z-1" href="<?=URL?>Tablero">
              <span class="float-left">Ver Detalles</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>

      </div><!-- / row Cards-->




      <div class="row">

        <div class="col-md-4">

          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-calendar-check-o"></i> Próximas Citas</div>

            <div class="list-group list-group-flush small">

              <?php foreach ($next_dates as $date) { ?>
                  <a class="list-group-item list-group-item-action" href="<?=URL?>Agenda">
                    <div class="media">
                      <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/45x45" alt="">
                      <div class="media-body">
                        <strong><?=$date['titulo']?></strong>
                        <div class="text-muted smaller"><strong>Fecha de la junta: </strong> <?=formatearFechaHora($date['fecha']);?></div>
                      </div>
                    </div>
                  </a>
              <?php } ?>

              <a class="list-group-item list-group-item-action" href="<?=URL?>Agenda">Ir a la agenda</a>

            </div>
          </div>                                                                                                                                          

        </div> <!-- mitad de citas y porximos a vencer -->

        <div class="col-md-4">

          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-exclamation-triangle"></i> Próximos a Vencer</div>

            <div class="list-group list-group-flush small">

              <?php foreach ($next_expire as $exp) { ?>
                  <a class="list-group-item list-group-item-action" href="<?=URL?>Objetivos/ver/<?=$exp['id_objetivo']?>">
                    <div class="media">
                      <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/45x45" alt="">
                      <div class="media-body">
                        <strong><?=$exp['titulo']?></strong>
                        <div class="text-muted smaller"> <strong>Fecha de vencimiento: </strong> <?=formatearFecha($exp['fecha_vencimiento']);?></div>
                      </div>
                    </div>
                  </a>
              <?php } ?>

              <a class="list-group-item list-group-item-action" href="<?=URL?>Tablero">Ir al tablero</a>

            </div>
          </div>                                                                                                                                          
        </div>    <!-- mitad de citas y porximos a vencer -->


        <div class="col-md-4 order-first">
          <!-- Example Pie Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-pie-chart"></i> Estatus General De Los Objetivos Activos </div>
            <div class="card-body">
              <canvas id="myPieChart" width="80%" height="60"></canvas>
            </div>
          </div>
        </div>

      </div> <!-- row -->
         
    </div>



<script src="<?=URL?>Views/template/SB_Admin/vendor/chart.js/Chart.min.js"></script>

<script>
  // -- Pie Chart Example
  var ctx = document.getElementById("myPieChart");
  var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ["Rojos", "Amarillos", "Verdes"],
      datasets: [{
        data: [ <?= $grafica[0] ?>,  <?= $grafica[1] ?>,  <?= $grafica[2] ?> ],
        backgroundColor: ['#dc3545', '#ffc107', '#28a745'],
      }],
    },
  });


  function validarContrasena(){
      var validado = true;
      var pass1 = $('#pass1').val();
      var pass2 = $('#pass2').val();
      // VALIDAR pass1
      if ( pass1 == '' || pass1.length < 2) {
          $('#pass1 ').addClass('is-invalid');
          validado = false;
      }else{
         $('#pass1').removeClass('is-invalid');
      }
      
      // VALIDAR pass1
      if ( pass2 != pass1 ) {
          $('#pass2').addClass('is-invalid');
          validado = false;
      }else{
         $('#pass2').removeClass('is-invalid');
      }
      
      // SI TODO ESTA BIEN SUMBITEAT EL FORMULARIO
      if (validado) {
          $('#form_contra').submit();
      }
  }


    $(document).ready(function() {

      if ("<?=$cambiaContra?>" == "undostres") {
            $('#contraModal').modal("show"); 
      }

    });

</script>




  <!-- Modal SET CONTRASEÑA -->
  <div class="modal fade" id="contraModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cambiar Contraseña</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=URL?>Home/cambiar_password" enctype="multipart/form-data" id="form_contra">
            
            <div class="form-group">
              <label>Contraseña</label>
              <input type="password" class="form-control" id="pass1" name="pass1">
              <div class="invalid-feedback">Ingresa un valor válido</div>
            </div>         

            <div class="form-group">
              <label>Confirmar Contraseña</label>
              <input type="password" class="form-control" id="pass2" name="pass2">
              <div class="invalid-feedback">Las contraseñas no coinciden</div>
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary" type="button" onclick="validarContrasena()">Aceptar</button>
        </div>
      </div>
    </div>
  </div>