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

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Turmas Inativas</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="float-right">
        <a href="listar/turma" class="btn btn-outline-laranja">Turmas Ativas</a>
    </div>

    <div class="clearfix"></div>

    <div class="card-body table-responsive p-0 mt-3">
        <table id="tabTurma" class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th style="width: 20%;">Série</th>
                    <th style="width: 20%;">Descrição</th>
                    <th style="width: 20%;">Período</th>
                    <th style="width: 20%;">Ano</th>
                    <th style="width: 20%;">Ação</th>
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
                    // Separar os dados
                    $id          = $dados->id;
                    $serie       = $dados->serie;
                    $descricao   = $dados->descricao;
                    $periodo_id  = $dados->periodo_id;
                    $periodo     = $dados->periodo;
                    $ano         = $dados->ano;
                    $idperiodo   = $dados->idperiodo;

                    // Mostrar na tela
                    echo '<tr>
                        <td>' . $serie . '</td>
                        <td>' . $descricao . '</td>
                        <td>' . $periodo . '</td>
                        <td>' . $ano . '</td>

                        <td>                            
                            <button type="button" class="btn btn-outline-laranja btn-sm" onclick="ativar(' . $id . ')">
                                <i class="fas fa-check"></i>
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
            location.href = "ativar/turma/" + id;
        }
    }
</script>