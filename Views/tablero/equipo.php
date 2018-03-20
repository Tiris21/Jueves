<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?=URL?>">Home</a>
        </li>
        <li class="breadcrumb-item active">Tablero de Equipo</li>
      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-12 col-sm-12 mb-3">
         
          <h1> <i class="fa fa-fw fa-table mb-3"></i> Tablero de Equipo </h1>

          <div class="table-responsive tablero">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Objetivo</th>
                  <th>Responsable</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Vencimiento</th>
                  <th>Dias p. Vencimiento</th>
                  <th>Estatus</th>
                  <th>T.A.</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>

                <tr>
                  <td>Vender $10,0000 en sucursal</td>
                  <td>Angel Alvarez</td>
                  <td>21/Feb/2018</td>
                  <td>15/Abr/2018</td>
                  <td> 43 </td>
                  <td class="text-white bg-danger"> 5 % </td>
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
                   
                <tr>
                  <td>Reducir Venta Negada</td>
                  <td>Salvador Cornejo</td>
                  <td>01/Ene/2018</td>
                  <td>21/Mar/2018</td>
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
                   
                <tr>
                  <td>Vender más calentadores solares</td>
                  <td>Yesenia Lizaran</td>
                  <td>10/Ene/2018</td>
                  <td>15/Mar/2018</td>
                  <td> 18 </td>
                  <td class=" text-white bg-success"> 70 % </td>
                  <td>  </td>
                  <td>
                    <select class="custom-select acciones">
                      <option value="seleccionar" selected>Seleccionar..</option>
                      <option value="ver">Ver Detalle</option>
                      <option value="avanzar">Avanzar</option>
                      <option value="asignar">Asignar</option>
                    </select>
                  </td>
                </tr>  
                   
                <tr>
                  <td>Mejoras con la fecha de entrega del producto</td>
                  <td>Victor Estrada</td>
                  <td>04/Feb/2018</td>
                  <td>28/Feb/2018</td>
                  <td> 5 </td>
                  <td class=" text-white bg-success"> 88 % </td>
                  <td>  </td>
                  <td>
                    <select class="custom-select acciones">
                      <option value="seleccionar" selected>Seleccionar..</option>
                      <option value="ver">Ver Detalle</option>
                      <option value="avanzar">Avanzar</option>
                      <option value="asignar">Asignar</option>
                    </select>
                  </td>
                </tr>  

              </tbody>

            </table>
          </div>
        </div>
      </div> <!-- / row -->
    </div>
</div>


<script>
    $('.acciones').change(function() {
        var opval = $(this).val();
        if(opval=="ver"){ 
            $('#verModal').modal("show"); 
        }else if(opval == "asignar") {
            $('#asignarModal').modal("show"); 
        }else if(opval == "avanzar") {
            $('#avanzarModal').modal("show"); 
        }
        $(this).val("seleccionar")
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
            <!-- <form> -->
              <div class="form-group">
                <label for="exampleInputEmail1">Usuario Responsable</label>
                <select class="custom-select form-control" id="inputGroupSelect01">
                  <option selected>Seleccionar...</option>
                  <option value="1">Omar Loera</option>
                  <option value="3">Angel Alvarez</option>
                  <option value="3">Salvador Cornejo</option>
                  <option value="3">Noe Jurado</option>
                </select>
              </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-primary" href="#">Aceptar</a>
            <!-- </form> -->
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
            <form>
              <div class="form-group">
                <label for="exampleInputEmail1">Porcentaje de Avance</label>
                <input type="number" step="0.1" class="form-control" id="exampleInputEmail1" max="100" min="0" aria-describedby="emailHelp" placeholder="">
              </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-primary" href="#">Aceptar</a>
            </form>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal VER -->
    <div class="modal fade" id="verModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detalles de Objetivo</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <h3>Titulo del objetivo</h3>
              <p> Descripcion del objetivo</p>
              <p>Responsable del objetivo</p>
              <p>Fecha de inicio</p>
              <p>Fecha de vencimiento</p>
              <p>Porcentaje de avance</p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" type="button" data-dismiss="modal">Aceptar</button>
            <!-- <a class="btn btn-primary" href="#">Aceptar</a> -->
          </div>
        </div>
      </div>
    </div>