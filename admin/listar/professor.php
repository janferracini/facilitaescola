<?php
//verificar se está logado
// if (!isset($_SESSION['hqs']['id'])) {
//     exit;
// }
// ?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Professores Cadastrados</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="float-right">
        <a href="cadastro/professor" class="btn btn-outline-laranja">Novo Professor</a>
    </div>

    <div class="clearfix"></div>

    <div class="card-body table-responsive p-0 mt-3">
        <table id="tabAdmin" class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php

            $sql = "SELECT  id, nome
                    FROM pessoa
                    WHERE tipo_cadastro = 3 AND status = 1
                    ORDER BY nome";
                    
            $consulta = $pdo->prepare($sql);
            $consulta->execute();

            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                $id = $dados->id;
                $nome = $dados->nome;

                echo '<tr>
                        <td>' . $nome . '</td>
                        <td><a href="cadastro/professor/' . $id . '" class="btn btn-success btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <button type="button" class="btn btn-danger btn-sm" onclick="excluir('.$id.')">
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
            location.href = "excluir/professor/" + id;
        }
    }
</script>