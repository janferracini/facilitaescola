<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Alunos Inativos</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">

    <div class="float-right">
        <a href="listar/aluno" class="btn btn-outline-laranja">Alunos Ativos</a>
    </div>

    <div class="clearfix"></div>

    <div class="card-body p-0 mt-3 pb-3">
        <table id="tabAluno" class="table ui celled table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th width=15%>Matrícula</th>
                    <th width=25%>Turma / Período</th>
                    <th width=20%>Ativar</th>
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
                        WHERE p.tipo_cadastro = 2 AND p.status = 0
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
</div>

<script>
    function ativar(id) {
        if (confirm("Deseja mesmo ativar?")) {
            location.href = "ativar/aluno/" + id;
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