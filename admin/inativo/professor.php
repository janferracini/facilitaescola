<?php
//verificar se está logado
// if (!isset($_SESSION['hqs']['id'])) {
//     exit;
// }
// 
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Professores Inativos</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="float-right">
        <a href="listar/professor" class="btn btn-outline-laranja">Professores Ativos</a>
    </div>

    <div class="clearfix"></div>

    <div class="card-body p-0 mt-3 pb-3">
        <table id="tabProfessor" class="table ui celled table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th style="width: 20%;">Ativar</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT  id, nome
                    FROM pessoa
                    -- admin = 1 | aluno = 2 | professor = 3 
                    WHERE tipo_cadastro = 3 AND status = 0
                    ORDER BY nome";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $id = $dados->id;
                    $nome = $dados->nome;

                    echo '<tr>
                        <td>' . $nome . '</td>
                        <td>                            
                            <button type="button" class="btn btn-outline-laranja btn-sm" onclick="ativar(' . $id . ')">
                                <i class="fas fa-check-circle"></i>
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
    function ativar(id) {
        //perguntar
        if (confirm("Deseja mesmo ativar?")) {
            //direcionar para exclusão
            location.href = "ativar/professor/" + id;
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