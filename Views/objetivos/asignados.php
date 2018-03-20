  <div class="content-wrapper">
    <div class="container-fluid">
      
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="Home">Home</a>
        </li>
        <li class="breadcrumb-item active">Objetivos Asignados</li>
      </ol>
      
      <div class="row">
        <div class="col-9">
          <h1> <i class="fa fa-fw fa-tasks"></i>Objetivos Asignados</h1>
          <!-- <p>This is an example of a blank page that you can use as a starting point for creating new ones.</p> -->
        </div>
        <!-- <div class="col-3 text-right">
          <a class="btn btn-outline-info" data-toggle="modal" role="button" aria-pressed="true" href="#" data-target="#nuevoModal">
            <i class="fa fa-fw fa-plus"></i> Nuevo </a>
        </div> -->
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card carta">
            <div class="card-body">
              <strong>Filtros</strong>
              
              <!-- <div class="dropdown">
                Estado:
                  <button class="btn btn-light dropdown-toggle" type="button" id="dropdosdawnMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <!- - <i class="fa fa-fw fa-sort-amount-asc"></i> - ->
                    Todos
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item disabled" href="#">Todos</a>
                    <a class="dropdown-item" href="#">Rojo</a>
                    <a class="dropdown-item" href="#">Amarillo</a>
                    <a class="dropdown-item" href="#">Azul</a>
                    <a class="dropdown-item" href="#">Verde</a>
                  </div>
              </div> -->

              <form class="form-inline">
                <label for="inputPassword6">Avance %</label>
                <select class="custom-select form-control mx-sm-3" id="inputGroupSelect01">
                  <option selected>Todas</option>
                  <option value="1">0 - 25 </option>
                  <option value="3">51 - 75</option>
                  <option value="2">76 - 100</option>
                </select>

                <label for="inputPassword6">Tipo</label>
                <select class="custom-select form-control mx-sm-3" id="inputGroupSelect01">
                  <option selected>Asignados</option>
                  <option selected>Completador</option>
                 <!--  <option value="1">Asignados</option>
                  <option value="3">No Asignados</option> -->
                </select>

                <label for="inputPassword6">Ordenar</label>
                <select class="custom-select form-control mx-sm-2" id="inputGroupSelect01">
                  <option selected>Fecha Vencimiento</option>
                  <option value="1">% de Avance</option>
                  <option value="3">Titulo</option>
                </select>

                <label for="inputPassword6">Buscar</label>
                <input type="text" id="inputPassword6" class="form-control mx-sm-3" aria-describedby="passwordHelpInline">
                
                <button type="button" class="btn btn-primary"> <i class="fa fa-fw fa-filter"></i> Filtrar </button>
              </form>

            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">

          <!-- BODY CARD -->
          <div class="card carta border-danger">
            <div class="card-block card-body ">
              <div>
                <h4 class="card-title text-danger"> Vender $ 10,000.00 <i class="fa fa-fw fa-support pull-right"></i> </h4> 
              </div>
              <p class="card-text">Llegar a vender un total de $ 10,000.00 en la sucursal</p>
              <p class="card-text"> <strong>Responsable: </strong> Gloria de Landa </p>
              <div class="progress">
                <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 5%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">5 %</div>
              </div>
            </div>
            <!--  FOOTER CARD -->
            <div class="card-footer bg-danger text-white">
              <div>
                <i>  Fecha Vencimiento: 10/Abril/2018  </i>
                <div class="pull-right">
                    <button type="button" class="btn btn-outline-light btn-card btn-card-danger"> 
                        <i class="fa fa-fw fa-trash"></i> Eliminar 
                    </button>  
                </div>
              </div>
            </div>          
          </div> <!-- /card -->

          <!-- BODY CARD -->
          <div class="card carta border-warning">
            <div class="card-block card-body ">
              <div>
                <h4 class="card-title text-warning"> Reducir venta negada. <i class="fa fa-fw fa-support pull-right"></i> </h4> 
              </div>
              <p class="card-text">En la sucursal reducir la vetna negada un 10%</p>
              <p class="card-text"> <strong>Responsable: </strong> Sinue Hernandez </p>
              <div class="progress">
                <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30 %</div>
              </div>
            </div>
            <!--  FOOTER CARD -->
            <div class="card-footer bg-warning text-white">
              <div>
                <i>  Fecha Vencimiento: 10/Abril/2018  </i>
                <div class="pull-right">
                    <button type="button" class="btn btn-outline-light btn-card btn-card-warning"> 
                        <i class="fa fa-fw fa-trash"></i> Eliminar 
                    </button>
                </div>
              </div>
            </div>          
          </div> <!-- /card -->
          
          <!-- BODY CARD -->
          <div class="card carta border-primary">
            <div class="card-block card-body ">
              <div>
                <h4 class="card-title text-primary"> Vender más calentadores solares <!-- <i class="fa fa-fw fa-support pull-right"></i> --> </h4> 
              </div>
              <p class="card-text">Llegar a vender un total de 100 calentadores en la sucursal</p>
              <p class="card-text"> <strong>Responsable: </strong> Cynthia Hernandez </p>
              <div class="progress">
                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 68%" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100">68 %</div>
              </div>
            </div>
            <!--  FOOTER CARD -->
            <div class="card-footer bg-primary text-white">
              <div>
                <i>  Fecha Vencimiento: 10/Abril/2018  </i>
                <div class="pull-right">
                    <button type="button" class="btn btn-outline-light btn-card btn-card-primary"> 
                        <i class="fa fa-fw fa-trash"></i> Eliminar 
                    </button>
                </div>
              </div>
            </div>          
          </div> <!-- /card -->
              
          <!-- BODY CARD -->
          <div class="card carta border-success">
            <div class="card-block card-body ">
              <div>
                <h4 class="card-title text-success"> Mejoras con la fecha de entrega del producto <i class="fa fa-fw fa-support pull-right"></i> </h4> 
              </div>
              <p class="card-text">Mejorar las entregas respetando la fecha requerida del cliente</p>
              <p class="card-text"> <strong>Responsable: </strong> Victor Estrada </p>
              <div class="progress">
                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85 %</div>
              </div>
            </div>
            <!--  FOOTER CARD -->
            <div class="card-footer bg-success text-white">
              <div>
                <i>  Fecha Vencimiento: 10/Abril/2018  </i>
                <div class="pull-right">
                    <button type="button" class="btn btn-outline-light btn-card btn-card-success"> 
                        <i class="fa fa-fw fa-trash"></i> Eliminar 
                    </button>
                </div>
              </div>
            </div>          
          </div> <!-- /card -->
          
        </div>
      </div>


    </div>
  </div>




    <!-- Nuevo Modal-->
    <div class="modal fade" id="nuevoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nuevo Objetivo</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="exampleInputEmail1">Titulo</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Descripcion</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Dias para cumplimiento</label>
                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Responsable</label>
                <select class="custom-select form-control" id="inputGroupSelect01">
                  <option selected>Seleccionar...</option>
                  <option value="1">Omar Loera</option>
                  <option value="3">Angel Alvarez</option>
                  <option value="3">Salvador Cornejo</option>
                  <option value="3">Noe Jurado</option>
                </select>
              </div>
              <!-- <div class="form-group">
                <label for="exampleInputPassword1"></label>
                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
              </div> -->
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-primary" href="login.html">Guardar</a>
            </form>
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
