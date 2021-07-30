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
                <h1 class="m-0 text-dark">Grades Inativas</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">

    <div class="float-right">
        <a href="listar/grade" class="btn btn-outline-laranja">Grades Ativas</a>
    </div>

    <div class="clearfix"></div>

    <div class="card-body p-0 mt-3 pb-3">
        <table id="tabGrade" class="table ui celled table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Turma</th>
                    <th style="width: 25%;">Disciplina</th>
                    <th style="width: 25%;">Professor</th>
                    <th style="width: 20%;">Ativar</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT  g.id gid, g.*, t.*, d.*, p.*, pe.nome, pd.*
                        FROM grade g
                        INNER JOIN turma t ON (t.id = g.turma_id)
                        INNER JOIN disciplina d ON (d.id = g.disciplina_id)
                        INNER JOIN professor p ON (p.id = g.professor_id)
                        INNER JOIN pessoa pe ON (pe.id = p.pessoa_id)
                        INNER JOIN periodo pd ON (pd.id = t.periodo_id)
                        WHERE g.status = 0";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $id         = $dados->gid;
                    $serie      = $dados->serie;
                    $descricao  = $dados->descricao;
                    $ano        = $dados->ano;
                    $disciplina = $dados->disciplina;
                    $nome       = $dados->nome;
                    $periodo    = $dados->periodo;

                    echo '<tr>
                        <td> ' . $serie . ' ' . $descricao . ' / ' . $periodo . ' (' . $ano . ')</td>
                        <td>' . $disciplina . '</td>
                        <td> ' . $nome . '</td>
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
        //perguntar
        if (confirm("Deseja mesmo ativar?")) {
            location.href = "ativar/grade/" + id;
        }
    }

    $(document).ready(function() {
        $("#tabGrade").DataTable({
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