<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>El Videoroom - Magallanes BBC</title>
    <link href="vendor/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="vendor/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/main.css">
    <script src="vendor/jquery.min.js"></script>
    <script src="vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="vendor/fontawesome/js/all.min.js"></script>
    <link rel="stylesheet" href="vendor/login.css">
  </head>
  <body id="login-page">
  <div class="container container-login">
    <div class="row justify-content-center align-middle">
      <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="card shadow-lg p-3 mb-5 bg-white rounded">
          <div class="card-body">
            <div class="form-group">
              <img class="img-fluid" src="img/logo-login.png" class="rounded mx-auto d-block" alt="">
            </div>
            <?php
              if(isset($_GET["status"])){
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$_GET["msg"].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
              }
            ?>
            <br>
            <form class="login-form" action="inicio/authentication.php" method="post">
              <div class="form-group">
                <input class="form-control" type="email" placeholder="usuario" name="correo">
              </div>
              <div class="form-group">
                <input class="form-control" type="password" placeholder="clave" name="clave">
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" value="Iniciar Sesion">
              </div>
            </form>
          </div>
        </div>
      </div> 
    </div>   
  </div>
  </body>
</html>