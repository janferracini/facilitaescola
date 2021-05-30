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

    <div class="card-body table-responsive p-0 mt-3">
        <table id="tabProfessor" class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th style="width: 20%;">Ação</th>
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
            location.href = "ativar/professor/" + id;
        }
    }
</script>