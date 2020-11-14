<?php
//iniciar a sessão
session_start();

ini_set("display_errors", 1);
ini_set("display_startup_erros", 1);
error_reporting(E_ALL);


//iniciar a variavel pagina
//$pagina = "paginas/login";

include "config/conexao.php";

$site   = $_SERVER['SERVER_NAME'];
$porta  = $_SERVER["SERVER_PORT"];
$url    = $_SERVER['SCRIPT_NAME'];
$h      = $_SERVER['REQUEST_SCHEME'];
//
$base = "$h://$site:$porta/$url"
//

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Facilita Escola | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" href="docs/assets/img/FE-icone.ico">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css">

  <link rel="stylesheet" href="dist/css/style.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="index.html">
        <img src="docs/assets/img/FE-logo.png" style="width: 250px;" />
      </a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Inicar seu acesso</p>

        <!-- ARQUIVO DE LOGIN -->
        <form action="../../index3.html" method="post">

          <!-- campos de informação de login -->
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="E-mail">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Senha">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>

          <!-- fim dos campos de informação de login -->

          <div class="row">
            <div class="col-8">
              <!--<div class="icheck-orange">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Lembrar-me
                </label>
              </div>-->
            </div> 
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-outline-laranja btn-block">Entrar</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="danger" >Login ou senha incorretos</p>

        <p class="mb-1">
          <a href="forgot-password.html">Esqueci minha senha</a>
        </p>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>

</body>

</html>