<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Professores Cadastrados</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="container">
        <div class="float-right">
            <a href="cadastro/professor" class="btn btn-outline-laranja">Novo Professor</a>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="card-body p-0 mt-3 pb-3">
        <table id="tabProfessor" class="table ui celled table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th style="width: 20%;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT  id, nome
                    FROM pessoa
                    WHERE tipo_cadastro = 3 AND status = 1
                    ORDER BY nome";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $id = $dados->id;
                    $nome = $dados->nome;

                    echo '<tr>
                        <td>' . $nome . '</td>
                        <td><a href="cadastro/professor/' . $id . '" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="inativar(' . $id . ')">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </td>
                    </tr>';
                }

                ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<script>
    //função para perguntar se deseja excluir. Se sim, direcionar para o endereço de exclusão
    function inativar(id) {
        //perguntar
        if (confirm("Deseja mesmo inativar?")) {
            //direcionar para exclusão
            location.href = "excluir/professor/" + id;
        }
    }

    $(document).ready(function() {
        $("#tabProfessor").DataTable({
            "language": {
                "search": "Filtrar ",
                "lengthMenu": "Mostrar _MENU_ resultados por página",
                "zeroRecords": "Registro não encontrado ",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "Registro não encontrado ",
                "infoFiltered": "(Busca feita em _MAX_ registros)",
                "paginate": {
                    "first": "Primeira",
                    "last": "Última",
                    "next": "PRÓXIMO",
                    "previous": "ANTERIOR"
                }
            }
        });
    })
</script>