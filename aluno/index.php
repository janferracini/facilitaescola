<?php
session_start();
if (!isset($_SESSION["facilita_escola"]["id"])) {
  echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
  exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 2) {
  echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
  exit;
}

ini_set("display_errors", 1);
ini_set("display_startup_erros", 1);
error_reporting(E_ALL);

$pagina = "../paginas/login";

include "../config/conexao.php";

$site   = $_SERVER['SERVER_NAME'];
$porta  = $_SERVER["SERVER_PORT"];
$url    = $_SERVER['SCRIPT_NAME'];
$h      = $_SERVER['REQUEST_SCHEME'];

$base = "$h://$site:$porta/$url"

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Facilita Escola</title>

  <base href="<?= $base; ?>">

  <link rel="shortcut icon" href="../docs/assets/img/FE-icone.ico">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../dist/css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

</head>

<body class="hold-transition sidebar-mini">

  <?php
  $pagina = $pagina . ".php";
  ?>

  <div class="wrapper pb-3">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item mt-2">
          <span class="mr-2 d-none d-lg-inline text-gray-200 ">
            <?= $_SESSION["facilita_escola"]["nome"]; ?>
          </span>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-orange elevation-4">
      <a href="#" class="brand-link">
        <img src="img/facilitaescola-logo.png" alt="Facilita Escola Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Facilita Escola</span>
      </a>

      <div class="sidebar">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar nav-legacy nav-flat nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header"></li>
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-home"></i>
                <p>Início</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="listar/atividade" class="nav-link">
                <i class="nav-icon fas fa-pencil-alt"></i>
                <p>
                  Atividades
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="listar/recado" class="nav-link">
                <i class="nav-icon fas fa-exclamation-triangle"></i>
                <p>
                  Recados
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cadastro/mensagem" class="nav-link">
                <i class="nav-icon fas fa-envelope"></i>
                <p>
                  Enviar Mensagem
                </p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <div class="content-wrapper pb-3">

      <div class="content">
        <div class="container-fluid">
          <?php
          $pagina = "home.php";
          if (isset($_GET["parametro"])) {
            $p = trim($_GET["parametro"]);
            $p = explode("/", $p);

            $pasta      = $p[0];
            $arquivo    = $p[1];

            $pagina = "$pasta/$arquivo.php";
            if (isset($p[2]))
              $id     = $p[2];
          }

          if (file_exists($pagina)) {
            include $pagina;
          } else {
            include $pagina = "../paginas/erro.php";
          }
          ?>

        </div>
      </div>
    </div>

    <aside class="control-sidebar control-sidebar-dark"></aside>

    <footer class="main-footer">
      Copyright &copy; 2021 <strong>Facilita Escola</strong>.
  </div>
  </footer>
  </div>

  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Sair do Sistema?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Selecione SAIR para efetuar o logout do Sistema</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
          <a class="btn btn-primary" href="sair.php">Sair</a>
        </div>
      </div>
    </div>
  </div>

  <?php

  ?>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="../plugins/mask/jquery.mask.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
  <script src="../dist/js/adminlte.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="../plugins/chart.js/Chart.min.js"></script>
  <script src="../plugins/sparklines/sparkline.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</body>

</html>