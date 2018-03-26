<!-- ESTILO PARA UTILIZAR LA LIBRERIA FULLCALENDAR -->
<link rel="stylesheet" href="<?=URL?>Views/template/css/fullcalendar.min.css">

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Mi Agenda</li>
      </ol>
      <!-- Icon Cards-->
      <div class="row mb-3">
        <div class="col-xl-9 col-sm-9">
          <h1> <i class="fa fa-fw fa-calendar-check-o mb-3"></i> Mi Agenda</h1>
        </div>
        <div class="col-3 text-right">
          <a class="btn btn-outline-info mr-5" data-toggle="modal" role="button" aria-pressed="true" href="#" data-target="#nuevoModal"> 
            <i class="fa fa-fw fa-plus"></i> Nueva Cita </a>
        </div>
      </div>

      
      <div class="row">
        <div class="col-xl-12 col-sm-12 mb-3">
            <!-- <div class="card mb-3"> -->
              <!-- <div class="card-header">
                <i class="fa fa-table"></i> Data Table Example</div>
              <div class="card-body"> </div>
            </div>-->

            <div class="row justify-content-center mt-5">
              <div class="col-xl-9 col-sm-9">  
                  <div id='calendar'></div>
              </div>
            </div>

        </div>
      </div>
        
    </div>
    </div>


<!-- FOR THE CALENDAR -->
<script src="<?=URL?>Views/template/js/moment.min.js"></script>
<script src="<?=URL?>Views/template/js/fullcalendar.min.js"></script>
<script src="<?=URL?>Views/template/js/es_fullcalendar.js"></script>

<script>
  $(function() {
    
    $('#calendar').fullCalendar({
      
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,listMonth'
      },
      locale      :     'es',
      themeSystem :     'bootstrap4',

      events: [
        <?php foreach ($mis_citas as $cita) { ?>
      
          {
            id     : <?=$cita['id_cita']?>,
            title  : '<?=$cita['titulo']?>',
            start  : '<?= str_replace(" ", "T", $cita['fecha']) ?>',
            url    : '<?=URL?>tablero',
            allDay : false, 
          },

        <?php } ?>
      ],

      //eventColor: '#378006'

    });

    $('#con-repeticion').hide();

  });

</script>




  <!-- Modal NUEVO -->
  <div class="modal fade" id="nuevoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar Cita</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="ver-body">
         <form method="post" action="<?=URL?>agenda/nueva">
              
              <div class="form-group">
                <label>Asunto</label>
                <input type="text" class="form-control" name="asunto" id="titulo">
                <div class="invalid-feedback">Ingresa un asunto valido</div>
              </div>

              <div class="form-group">
                <label>Asistentes</label>
                <select class="custom-select form-control" name="responsables[]" id="responsable" multiple>
                  <!-- <option selected>Seleccionar...</option> -->
                  <?php foreach ($mi_equipo as $usr) { ?>
                    <option value="<?=$usr['id_usuario']?>"><?=$usr['nombre']?></option>
                  <?php } ?>
                </select>
                <div class="invalid-feedback">Selecciona al menos un asistente</div>
              </div>

              <div class="form-group">
                <label>Objetivo a revisar</label>
                <select class="custom-select form-control" name="objetivo">
                  <option selected>Seleccionar...</option>
                  <?php foreach ($mis_objetivos as $obj) { ?>
                    <option value="<?=$obj['id_objetivo']?>"><?=$obj['titulo']?></option>
                  <?php } ?>
                </select>
              </div>
              
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label>Fecha Inicio</label>
                    <input type="date" value="<?=date("Y-m-d")?>" id="fecha_inicio" name="fecha_inicio" class="form-control">
                    <div class="invalid-feedback">Ingresa una fecha valida</div>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Hora</label>
                    <input type="time" value="<?=date("H:i")?>" class="form-control" id="hora" name="hora" onchange="//alert(this.value)">
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <label>Duración</label>
                  <select class="custom-select form-control" name="duracion">
                    <option value="0" selected>30 Minutos</option>
                    <option value="1">1 Hora</option>
                    <option value="1.5">1 Hora y media</option>
                    <option value="2">2 Horas</option>
                    <option value="3">3 Horas</option>
                    <option value="4">4 Horas</option>
                    <option value="5">5 Horas</option>
                  </select>
              </div>

              <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="check-periodicidad" name="check" value="ok" onchange="togglePerioricidad(this.checked)">
                <label class="form-check-label">Programar periodicidad</label>
              </div>
              
              <!-- CON PERIODICIDAD -->
              <div id="con-repeticion">
                
              <div class="form-group">
                <label class="font-weight-bold">Frecuencia</label>
                  <select class="custom-select form-control" name="frecuencia">
                    <option value="diario" >Diario</option>
                    <option value="semanal">Semanal</option>
                    <option value="mensual" selected>Mensual</option>
                  </select>
              </div>
              
              <div id="mensual">
              
              <div class="row">
                <div class="col-2 pr-0 mt-1">  
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio-mensual" value="numero" checked>
                    <label class="form-check-label"> El día </label>
                  </div>
                </div>
                <div class="col-2 pl-0">  
                  <div class="form-group">
                      <input type="number" value="<?=date("d")?>" name="dia_mensual" class="form-control form-control-sm">
                  </div>
                </div>
                <div class="col-8 pl-0 mt-1"> de cada mes</div>
              </div>

              <div class="row">
                <div class="col-2 pr-0 mt-1">  
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio-mensual" value="dia" checked>
                    <label class="form-check-label"> El </label>
                  </div>
                </div>
                <div class="col-3 pl-0">  
                      <select class="custom-select form-control form-control-sm" name="posicion">
                        <option value="first" selected>Primer</option>
                        <option value="second">Segundo</option>
                        <option value="third">Tercer</option>
                        <option value="fourth">Cuarto</option>
                      </select>
                </div>
                <div class="col-3 pl-0">  
                      <select class="custom-select form-control form-control-sm" name="dia_semana">
                        <option value="monday" selected>Lunes</option>
                        <option value="tuesday">Martes</option>
                        <option value="wednesday">Miercoles</option>
                        <option value="thursday">Jueves</option>
                        <option value="friday">Viernes</option>
                        <option value="saturday">Sabado</option>
                      </select>
                </div>
                <div class="col-4 pl-0 mt-1"> de cada mes</div>
              </div>


              </div> <!-- mensual -->
              


              <!-- FINALIZACION  -->
              <label class="mt-4 font-weight-bold">Finalización</label> 
              <div class="row">
                <div class="col-5 pr-0 mt-1">  
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio-fin" value="for" checked>
                    <label class="form-check-label"> Cant. de repeticiones </label>
                  </div>
                </div>
                <div class="col-3 pl-0">  
                  <div class="form-group">
                      <input type="number" value="10" name="repeticiones" class="form-control form-control-sm">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-3 pr-0 mt-1">  
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio-fin" value="while" checked>
                    <label class="form-check-label"> Finalizar el  </label>
                  </div>
                </div>
                <div class="col-4 pl-0">  
                    <input type="date" value="<?=date("Y-m-d")?>" name="fecha_fin" class="form-control form-control-sm">
                </div>
              </div>



              </div> <!-- con-repeticion -->

          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary" type="button" onclick="validar()">Guardar</button>
            </form>
          </div>
      </div>
    </div>
  </div>


<script>
  function togglePerioricidad(estado){
      if(estado){
        $('#con-repeticion').show();
      }else{
        $('#con-repeticion').hide();
      }
  }

  function validar(){
    var elementos = new Array();
    var selects = new Array();
    var validado = true;

    elementos.push('#titulo');
    selects.push('#responsable');


// alert(  $(elementos[i]).next().text()  );
// console.log(  $(elementos[1]).val().length  );

    for (var i = 0; i < elementos.length ; i++) {
      if ( $(elementos[i]).val() == '' || $(elementos[i]).val().length < 5) {
          $(elementos[i]).addClass('is-invalid');
          validado = false;
      }else{
         $(elementos[i]).removeClass('is-invalid');
      }
    }

    for (var i = 0; i < selects.length ; i++) {
      if ( $(selects[i]).val().length == 0) {
          $(selects[i]).addClass('is-invalid');
          validado = false;
      }else{
         $(selects[i]).removeClass('is-invalid');
      }
    }



    if (validado) {
      $('form').submit();
    }
  }
</script>