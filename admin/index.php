<?php
session_start();

ini_set("display_errors", 1);
ini_set("display_startup_erros", 1);
error_reporting(E_ALL);

$pagina = "home";

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

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../dist/css/style.css">

  <link rel="stylesheet" href="http://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>


<body class="hold-transition sidebar-mini">
  <?php
  $pagina = $pagina . ".php";


  /* VALIDAÇÃO DE LOGADO. SE NÃO TIVER, IR PARA PÁGINA DE LOGIN
  if (!isset($_SESSION["facilita_escola"]["id"])) {
    //incluir login
    include $pagina;
  } else { 
  */

  ?>

  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Botão CONFIG -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-key"></i>
          </a>

        </li>
        <!-- Botão SAIR -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-orange elevation-4">
      <!-- Brand Logo -->
      <a href="index3.php" class="brand-link">
        <img src="img/facilitaescola-logo.png" alt="Facilita Escola Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Facilita Escola</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar nav-legacy nav-flat nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-plus-square"></i>
                <p>
                  Cadastros
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="cadastro/aluno" class="nav-link">
                    <i class="fas fa-user-graduate nav-icon"></i>
                    <p>Alunos</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="cadastro/professor" class="nav-link">
                    <i class="fas fa-apple-alt nav-icon"></i>
                    <p>Professores</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="cadastro/admin" class="nav-link">
                    <i class="fas fa-laptop-code nav-icon"></i>
                    <p>Equipe Administrativa</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="cadastro/disciplina" class="nav-link">
                    <i class="fas fa-book-open nav-icon"></i>
                    <p>Disciplina</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="cadastro/turma" class="nav-link">
                    <i class="fas fa-chalkboard nav-icon"></i>
                    <p>Turmas</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="pages/calendar.html" class="nav-link">
                <i class="nav-icon fas fa-pencil-alt"></i>
                <p>
                  Atividades
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="pages/calendar.html" class="nav-link">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>
                  Eventos
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="pages/calendar.html" class="nav-link">
                <i class="nav-icon fas fa-exclamation-triangle"></i>
                <p>
                  Recados
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="pages/calendar.html" class="nav-link">
                <i class="nav-icon fas fa-envelope"></i>
                <p>
                  Mensagens
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="pages/calendar.html" class="nav-link">
                <i class="nav-icon fas fa-folder-open"></i>
                <p>
                  Arquivos
                </p>
              </a>
            </li>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <?php

          $pagina = "home.php";

          if (isset($_GET["parametro"])) {
            //recuperar o parametro
            $p = trim($_GET["parametro"]);
            $p = explode("/", $p);

            $pasta      = $p[0];
            $arquivo    = $p[1];

            $pagina = "../$pasta/$arquivo.php";
            if (isset($p[2]))
              $id     = $p[2];
          }


          if (file_exists($pagina)) {
            include $pagina;
          } else {
            include "../erro.php";
          }
          ?>

        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      Copyright &copy; 2020 <strong>Facilita Escola</strong>.
  </div>
  </footer>
  </div>
  <!-- ./wrapper -->
  <?php
  //}
  ?>
  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Parsley para validar -->
  <script src="../dist/js/parsley.min.js"></script>
  <!-- AdminLTE -->
  <script src="../dist/js/adminlte.js"></script>
  <!-- daterangepicker -->
  <script src="../plugins/moment/moment.min.js"></script>
  <script src="../plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>


  <script src="http://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="../plugins/chart.js/Chart.min.js"></script>
  <script src="../dist/js/demo.js"></script>
  <script src="../dist/js/pages/dashboard3.js"></script>
</body>

</html>