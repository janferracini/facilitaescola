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
                <h1 class="m-0 text-dark">Turmas Inativas</h1>
            </div>
        </div>
    </div>
</div>
<div class="container">

    <div class="float-right">
        <a href="listar/turma" class="btn btn-outline-laranja">Turmas Ativas</a>
    </div>

    <div class="clearfix"></div>

    <div class="card-body p-0 mt-3 pb-3">
        <table id="tabTurma" class="table ui celled table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 20%;">Série</th>
                    <th style="width: 20%;">Descrição</th>
                    <th style="width: 20%;">Período</th>
                    <th style="width: 20%;">Ano</th>
                    <th style="width: 20%;">Ativar </th>
                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT  t.id,
                            t.serie,
                            t.descricao,
                            t.ano,
                            t.periodo_id,
                            p.id idperiodo,
                            p.periodo
                    FROM turma t
                    INNER JOIN periodo p on (p.id = t.periodo_id)
                    WHERE status = 0
                    ORDER BY serie";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $id          = $dados->id;
                    $serie       = $dados->serie;
                    $descricao   = $dados->descricao;
                    $periodo_id  = $dados->periodo_id;
                    $periodo     = $dados->periodo;
                    $ano         = $dados->ano;
                    $idperiodo   = $dados->idperiodo;

                    echo '<tr>
                        <td>' . $serie . '</td>
                        <td>' . $descricao . '</td>
                        <td>' . $periodo . '</td>
                        <td>' . $ano . '</td>

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
            location.href = "ativar/turma/" + id;
        }
    }

    $(document).ready(function() {
        $("#tabTurma").DataTable({
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