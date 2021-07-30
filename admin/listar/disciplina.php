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

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Disciplinas Cadastradas</h1>
            </div>
        </div>
    </div>
</div>
<div class="container">

    <div class="float-right">
        <a href="cadastro/disciplina" class="btn btn-outline-laranja">Nova Disciplina</a>
    </div>

    <div class="clearfix"></div>

    <div class="card-body p-0 mt-3 pb-3">
        <table id="tabDisciplina" class="table ui celled table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Disciplina</th>
                    <th style="width: 20%;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT  *
                    FROM disciplina
                    WHERE status = 1
                    ORDER BY disciplina";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $id = $dados->id;
                    $disciplina = $dados->disciplina;

                    echo '<tr>
                        <td>' . $disciplina . '</td>
                        <td><a href="cadastro/disciplina/' . $id . '" class="btn btn-outline-info btn-sm">
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
</div>

<script>
    function inativar(id) {
        if (confirm("Deseja mesmo inativar?")) {
            location.href = "excluir/disciplina/" + id;
        }
    }

    $(document).ready(function() {
        $("#tabDisciplina").DataTable({
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