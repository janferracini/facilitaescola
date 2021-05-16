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
                <h1 class="m-0 text-dark">Turmas Cadastradas</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="float-right">
        <a href="cadastro/turma" class="btn btn-outline-laranja">Nova Turma</a>
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
                    <th style="width: 20%;">Ações</th>
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
                    ORDER BY serie";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    // Separar os dados
                    $id = $dados->id;
                    $serie = $dados->serie;
                    $descricao = $dados->descricao;
                    $periodo_id = $dados->periodo_id;
                    $periodo = $dados->periodo;
                    $ano = $dados->ano;
                    $idperiodo = $dados->idperiodo;

                    // Mostrar na tela
                    echo '<tr>
                        <td>' . $serie . '</td>
                        <td>' . $descricao . '</td>
                        <td>' . $periodo . '</td>
                        <td>' . $ano . '</td>

                        <td><a href="cadastro/turma/' . $id . '" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="excluir(' . $id . ')">
                                <i class="fas fa-trash"></i>
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
    function excluir(id) {
        //perguntar
        if (confirm("Deseja mesmo excluir?")) {
            //direcionar para exclusão
            location.href = "excluir/turma/" + id;
        }
    }
</script>