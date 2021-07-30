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
                <h1 class="m-0 text-dark">Alunos Cadastrados</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">

    <div class="float-right">
        <a href="cadastro/aluno" class="btn btn-outline-laranja">Novo Aluno</a>
    </div>

    <div class="clearfix"></div>

    <div class="card-body p-0 mt-3 pb-3">
        <table id="tabAluno" class="table ui celled table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th width=15%>Matrícula</th>
                    <th width=25%>Turma / Período</th>
                    <th width=20%>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT  p.id pid, p.nome, m.*, tm.*, t.*, pe.*
                    FROM pessoa p
                    INNER JOIN matricula m ON (m.pessoa_id = p.id)
                    INNER JOIN turma_matricula tm ON (tm.matricula_id = m.id)
                    INNER JOIN turma t ON (t.id = tm.turma_id)
                    INNER JOIN periodo pe ON (pe.id = t.periodo_id)
                    WHERE p.tipo_cadastro = 2 AND p.status = 1
                    ORDER BY nome";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $id      = $dados->pid;
                    $nome    = $dados->nome;
                    $matricula = $dados->matricula;
                    $serie   = $dados->serie;
                    $descricao = $dados->descricao;
                    $periodo = $dados->periodo;

                    echo '<tr>
                        <td>' . $nome . '</td>
                        <td>' . $matricula . '</td>
                        <td>' . $serie . ' ' . $descricao . ' / ' . $periodo . '</td>
                        <td><a href="cadastro/aluno/' . $id . '" class="btn btn-outline-info btn-sm">
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
            location.href = "excluir/aluno/" + id;
        }
    }

    $(document).ready(function() {
        $("#tabAluno").DataTable({
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