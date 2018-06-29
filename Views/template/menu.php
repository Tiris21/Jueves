  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="<?=URL?>Home">VHA Project</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarResponsive">
      
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Home">
          <a class="nav-link" href="<?=URL?>Home">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>

  <!--
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Objetivos">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseObjetivos" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-bullseye"></i>
            <span class="nav-link-text">Objetivos</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseObjetivos">
            <li>
              <a href="<?=URL?>Objetivos">Mis Objetivos</a>
            </li>
            <li>
              <a href="<?=URL?>Objetivos/asignados">Objetivos Asignados</a>
            </li>
           <li>
              <a class="nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti2">Third Level</a>
              <ul class="sidenav-third-level collapse" id="collapseMulti2">
                <li>
                  <a href="#">Third Level Item</a>
                </li>
                <li>
                  <a href="#">Third Level Item</a>
                </li>
                <li>
                  <a href="#">Third Level Item</a>
                </li>
              </ul>
            </li> 
          </ul>
        </li>
  -->

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tablero">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseTablero" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Tableros</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseTablero">
            <li>
              <a href="<?=URL?>Tablero">Mi Tablero</a>
            </li>
            <li>
              <a href="<?=URL?>Tablero/Equipo">Tablero De Mi Equipo</a>
            </li>
          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Equipo">
          <a class="nav-link" href="<?=URL?>Equipo">
            <i class="fa fa-fw fa-users"></i>
            <span class="nav-link-text">Equipo</span>
          </a>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Agenda">
          <a class="nav-link" href="<?=URL?>Agenda">
            <i class="fa fa-fw fa-calendar-check-o"></i>
            <span class="nav-link-text">Agenda</span>
          </a>
        </li>

        <!-- <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Graficas">
          <a class="nav-link" href="charts.html">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">Gráficas</span>
          </a>
        </li> -->

      </ul>

      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
  


 <!--  header -->
      <ul class="navbar-nav ml-auto">

        <li class="nav-item">
          <span class="nav-link ml-6">
            <i class="fa fa-fw fa-user"></i> <?=$_SESSION['nombre']?>
          <span>
        </li>
        
        <!-- NOTIFICACIONES -->
        <?php 
          use Models\Dashboard as Dashboard; 
          $dashboard = new Dashboard();

          $notificaciones = $dashboard->getNotificaciones($_SESSION['id_usuario'], $_SESSION['last_login']);
          $hay_not = ($notificaciones && $notificaciones->num_rows > 0 ? $notificaciones->num_rows : false);
        ?>
        <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <?php if ($hay_not) { ?>
            <span class="d-lg-none">Notificaciones
              <span class="badge badge-pill badge-warning">Nuevas</span>
            </span>
              <span class="indicator text-warning d-none d-lg-block">
                <i class="fa fa-fw fa-circle"></i>
              </span>
            <?php } ?>
          </a>

          <div class="dropdown-menu" id="innerScroll" aria-labelledby="alertsDropdown" style="right: 0; left: auto; 
          <?= ($hay_not >= 6) ? 'overflow-y: scroll; height: 400px;': ''; ?>"> <!-- cambiar para hacerlo con kquery -->
            <h6 class="dropdown-header"><?= ($hay_not ? '' : 'Sin ') ?>Notificaciones</h6>
          
          <?php 
            foreach ($notificaciones as $not) { 
              switch ($not['clase']) {
                case 'avanzar':
          ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?=URL?>Objetivos/ver/<?=$not['id_objetivo']?>">
                      <span class="text-primary">
                        <strong><i class="fa fa-long-arrow-up fa-fw"></i>Avance</strong>
                      </span>
                      <span class="small float-right text-muted"><?=formatearFechaHora($not['fecha_creacion'])?></span>
                      <div class="dropdown-message small">En objetivo: "<?=$not['titulo']?>"</div>
                    </a>
                  
          <?php         
                break;
                case 'apropiar':
                  // if ($not['id_usuario'] == $_SESSION['id_usuario']) {
                
          ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?=URL?>Objetivos/ver/<?=$not['id_objetivo']?>">
                      <span class="text-warning">
                        <strong><i class="fa fa-magic fa-fw"></i>Apropiación</strong>
                      </span>
                      <span class="small float-right text-muted"><?=formatearFechaHora($not['fecha_creacion'])?></span>
                      <div class="dropdown-message small">Se te asignó un objetivo: "<?=$not['titulo']?>"</div>
                    </a>          
          <?php         
                  // }
                break;
                case 'comentar':
          ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?=URL?>Objetivos/ver/<?=$not['id_objetivo']?>">
                      <span class="text-secondary">
                        <strong><i class="fa fa-comment fa-fw"></i>Comentario</strong>
                      </span>
                      <span class="small float-right text-muted"><?=formatearFechaHora($not['fecha_creacion'])?></span>
                      <div class="dropdown-message small">En el objetivo: "<?=$not['titulo']?>"</div>
                    </a>             
          <?php         
                break;
                case 'asignar':
          ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?=URL?>Objetivos/ver/<?=$not['id_objetivo']?>">
                      <span class="text-danger">
                        <strong><i class="fa fa-support fa-fw"></i>Asignación</strong>
                      </span>
                      <span class="small float-right text-muted"><?=formatearFechaHora($not['fecha_creacion'])?></span>
                      <div class="dropdown-message small">Asignaste el objetivo: "<?=$not['titulo']?>"</div>
                    </a>
          <?php 
                break;
              } // switch
            } // foreach
          ?>

          </div>
        </li>



        <!-- BARRA DE BUSQUEDA -->
        <!-- <li class="nav-item">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Search for...">
              <span class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li> -->
        
     <!--  cambio de diseño del menu del header -->
       <!--  <li class="nav-item dropdown">        
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="fa fa-fw fa-sign-out"></i>Cerrar Sesión
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
        </li> -->

        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Cerrar Sesión</a>
        </li>

      </ul>
    </div>
  </nav>


<script>

  var step = 100;
  $('#innerScroll').bind('mousewheel', function(e) {
      if(e.originalEvent.wheelDelta / 120 > 0) {
          $("#innerScroll").animate({
            scrollTop: "-=" + step + "px"
           });
      } else {
          $("#innerScroll").animate({
            scrollTop: "+=" + step + "px"
          });
      }
  });


</script>