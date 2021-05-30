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
                <h1 class="m-0 text-dark">Disciplinas Inativas</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="float-right">
        <a href="listar/disciplina" class="btn btn-outline-laranja">Disciplinas Ativas</a>
    </div>

    <div class="clearfix"></div>

    <div class="card-body table-responsive p-0 mt-3">
        <table id="tabDisciplina" class="table table-hover text-nowrap">
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
                    WHERE status = 0
                    ORDER BY disciplina";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    // Separar os dados
                    $id = $dados->id;
                    $disciplina = $dados->disciplina;

                    // Mostrar na tela
                    echo '<tr>
                        <td>' . $disciplina . '</td>
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
            location.href = "ativar/disciplina/" + id;
        }
    }
</script>