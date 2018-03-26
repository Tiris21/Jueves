  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="Home">VitrObjetivos</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarResponsive">
      
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Home">
          <a class="nav-link" href="Home">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Home</span>
          </a>
        </li>

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
            <!-- <li>
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
            </li> -->
          </ul>
        </li>


        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tablero">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseTablero" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Tableros de Control</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseTablero">
            <li>
              <a href="<?=URL?>Tablero">Mi Tablero</a>
            </li>
            <li>
              <a href="<?=URL?>Tablero/Equipo">Tablero de mi Equipo</a>
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

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Graficas">
          <a class="nav-link" href="charts.html">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">Gráficas</span>
          </a>
        </li>

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
        
        <!-- NOTIFICACIONES -->
        <!-- <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <span class="d-lg-none">Notificaciones
              <span class="badge badge-pill badge-warning">6 Nuevas</span>
            </span>
            <span class="indicator text-warning d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">New Alerts:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-danger">
                <strong>
                  <i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">View all alerts</a>
          </div>
        </li> -->

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

        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Cerrar Sesión</a>
        </li>

      </ul>
    </div>
  </nav>