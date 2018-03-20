<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>VitrObjetivos - Inicia Sesion</title>
  <!-- Bootstrap core CSS-->
  <link href="<?=URL?>Views/template/SB_Admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="<?=URL?>Views/template/SB_Admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="<?=URL?>Views/template/SB_Admin/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Iniciar Sesión</div>
      <div class="card-body">
        <form action="login" method="POST">
          <div class="form-group">
            <label for="exampleInputEmail1">No. de usuario</label>
            <input class="form-control" id="usuario" type="text" name="usuario">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Contraseña</label>
            <input class="form-control" id="pass" name="pass" type="password">
          </div>
          <!-- <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox"> Remember Password</label>
            </div>
          </div> -->
          <?php if(isset($error)) { ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error de autenticación!</strong> Verifica que el usuario y la contraseña sean correctos.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <?php } ?>
          <button type="submit" class="btn btn-primary btn-block mt-4"> Entrar </button>
        </form>
        <div class="text-center">
          <!-- <a class="d-block small mt-3" href="register.html">Register an Account</a> -->
          <!-- <a class="d-block small" href="forgot-password.html">Forgot Password?</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="<?=URL?>Views/template/SB_Admin/vendor/jquery/jquery.min.js"></script>
  <script src="<?=URL?>Views/template/SB_Admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="<?=URL?>Views/template/SB_Admin/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
