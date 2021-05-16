<?php
// verificar se está logado
if (!isset($_SESSION['facilita_escola']['id'])) {
    exit;
}

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Relatórios</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="card-body table-responsive p-0 mt-3">
        <table id="tabTurma" class="table table-hover text-nowrap">
            <tbody>
                <tr>
                    <td>Alunos por Turma </td>
                    <td style="width: 200px;">
                        <a href="" class="btn btn-outline-laranja btn-sm ">Gerar <i class="fas fa-check"></i> </a>
                    </td>
                </tr>
                <tr>
                    <td>Alunos por Professor </td>
                    <td style="width: 200px;">
                        <a href="" class="btn btn-outline-laranja btn-sm ">Gerar <i class="fas fa-check"></i> </a>
                    </td>
                </tr>
                <tr>
                    <td>Atividades por Turma </td>
                    <td style="width: 200px;">
                        <a href="" class="btn btn-outline-laranja btn-sm ">Gerar <i class="fas fa-check"></i> </a>
                    </td>
                </tr>
                <tr>
                    <td>Recados por Turma </td>
                    <td style="width: 200px;">
                        <a href="" class="btn btn-outline-laranja btn-sm ">Gerar <i class="fas fa-check"></i> </a>
                    </td>
                </tr>
                <tr>
                    <td>Recados por mês </td>
                    <td style="width: 200px;">
                        <a href="" class="btn btn-outline-laranja btn-sm ">Gerar <i class="fas fa-check"></i> </a>
                    </td>
                </tr>
                <tr>
                    <td>Mensagens recebidas por mês</td>
                    <td style="width: 200px;">
                        <a href="" class="btn btn-outline-laranja btn-sm ">Gerar <i class="fas fa-check"></i> </a>
                    </td>
                </tr>
                <tr>
                    <td>Aniversariantes do mês </td>
                    <td style="width: 200px;">
                        <a href="" class="btn btn-outline-laranja btn-sm ">Gerar <i class="fas fa-check"></i> </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>