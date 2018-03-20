  <div class="content-wrapper">
    <div class="container-fluid">
      
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.html">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Blank Page</li>
      </ol>
      
      <div class="row">
        <div class="col-9">
          <h1> <i class="fa fa-fw fa-tasks"></i> Mis Objetivos</h1>
          <!-- <p>This is an example of a blank page that you can use as a starting point for creating new ones.</p> -->
        </div>
        <div class="col-3 text-right">
          <button type="button" class="btn btn-outline-info" disabled>Nuevo</button>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <!-- BODY CARD -->
          <div class="card mb-3 border-danger">
            <div class="card-block card-body objetfivo_rojo_bd">
              <div>
                <h4 class="card-title text-danger"> Vender $ 10,000.00 <i class="fa fa-fw fa-tasks pull-right"></i> </h4> 
              </div>
              <p class="card-text">Llegar a vender un total de $ 10,000.00 en la sucursal</p>
              <p class="card-text"> <strong>Responsable: </strong> Yo </p>
              <div class="progress">
                <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 5%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">5 %</div>
              </div>
            </div>
            <!--  FOOTER CARD -->
            <div class="card-footer objetivo_rojo_ft text-white">
              <div>
                <i>  Fecha Vencimiento: 10/Abril/2018  </i>
                <div class="pull-right">
                    <button type="button" class="btn btn-outline-light btn-card">  <i class="fa fa-fw fa-tasks"></i> Avanzar 1  </button>
                    <button type="button" class="btn btn-outline-light btn-card">  <i class="fa fa-fw fa-tasks"></i> Avanzar 2  </button>
                    <button type="button" class="btn btn-outline-light btn-card">  <i class="fa fa-fw fa-tasks"></i> Avanzar 3  </button>
                </div>
              </div>
            </div>          
          </div> <!-- /card -->
          
        </div>
      </div>


    </div>
  </div>


<script>
  $(document).ready(function(){
      $(".btn-card").css("padding-top", "2");
      $(".btn-card").css("padding-bottom", "2");
  });
</script>
