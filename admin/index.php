<?php
session_start();
if (!isset($_SESSION["facilita_escola"]["id"])) {
  echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
  exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
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


  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <!-- <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css"> -->

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

  <link rel="stylesheet" href="../dist/css/style.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <!-- <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"> -->
</head>


<body class="hold-transition sidebar-mini">
  <?php
  $pagina = $pagina . ".php";


  //VALIDAÇÃO DE LOGADO. SE NÃO TIVER, IR PARA PÁGINA DE LOGIN
  if (!isset($_SESSION["facilita_escola"]["id"])) {
    //incluir login
    include $pagina;
  } else {

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
          <li class="nav-item mt-2">
            <span class="mr-2 d-none d-lg-inline text-gray-200 ">
              <?= $_SESSION["facilita_escola"]["nome"]; ?>
            </span>
          </li>
          <!-- Botão SAIR -->
          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt"></i>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-orange elevation-4">
        <!-- Brand Logo -->
        <a href="index.php" class="brand-link">
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
                  <i class="nav-icon fas fa-home"></i>
                  <p>Início</p>
                </a>
              </li>
              <li class="nav-item has-treeview">
                <a href="" class="nav-link">
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
                      <p>Aluno</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="cadastro/professor" class="nav-link">
                      <i class="fas fa-apple-alt nav-icon"></i>
                      <p>Professor</p>
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
                      <p>Turma</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="cadastro/grade" class="nav-link">
                      <i class="nav-icon fas fa-chalkboard-teacher"></i>
                      <p>
                        Grade
                      </p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="cadastro/atividade" class="nav-link">
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
                <a href="listar/mensagem" class="nav-link">
                  <i class="nav-icon fas fa-envelope"></i>
                  <p>
                    Mensagens
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="listar/relatorio" class="nav-link">
                  <i class="nav-icon fas fa-print"></i>
                  <p>
                    Relatórios
                  </p>
                </a>
              </li>

              <li class="nav-item has-treeview">
                <a href="" class="nav-link">
                  <i class="nav-icon far fa-times-circle"></i>
                  <p>
                    Inativos
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="inativo/aluno" class="nav-link">
                      <i class="fas fa-user-graduate nav-icon"></i>
                      <p>Alunos</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="inativo/professor" class="nav-link">
                      <i class="fas fa-apple-alt nav-icon"></i>
                      <p>Professores</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="inativo/admin" class="nav-link">
                      <i class="fas fa-laptop-code nav-icon"></i>
                      <p>Equipe Administrativa</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="inativo/disciplina" class="nav-link">
                      <i class="fas fa-book-open nav-icon"></i>
                      <p>Disciplina</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="inativo/turma" class="nav-link">
                      <i class="fas fa-chalkboard nav-icon"></i>
                      <p>Turmas</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="inativo/grade" class="nav-link">
                      <i class="nav-icon fas fa-chalkboard-teacher"></i>
                      <p>
                        Grade
                      </p>
                    </a>
                  </li>
                </ul>
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

            // referente a pagina que será aberta
            if (isset($_GET["parametro"])) {
              //recuperar o parametro
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
              include "../erro.php";
            }
            ?>

          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        Copyright &copy; 2021 <strong>Facilita Escola</strong>.
    </div>
    </footer>
    </div>
    <!-- ./wrapper -->


    <!-- Logout Modal-->
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
  }
  ?>


  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="../plugins/mask/jquery.mask.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
  <script src="../dist/js/adminlte.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <!-- ChartJS -->
  <script src="../plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="../plugins/sparklines/sparkline.js"></script>

</body>

</html>