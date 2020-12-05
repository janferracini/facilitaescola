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
                <h1 class="m-0 text-dark">Administradores Cadastrados</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="float-right">
        <a href="cadastro/admin" class="btn btn-success">Novo Registro</a>
        <a href="listar/admin" class="btn btn-info">Listar Registro</a>
    </div>

    <div class="clearfix"></div>

    <div class="card-body table-responsive p-0 mt-3">
        <table id="tabTurma" class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php

            $sql = "SELECT  id, nome
                    FROM pessoa
                    WHERE tipo_cadastro = 1 AND status = 1
                    ORDER BY nome";
                    
            $consulta = $pdo->prepare($sql);
            $consulta->execute();

            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                $id = $dados->id;
                $nome = $dados->nome;

                echo '<tr>
                        <td>' . $id . '</td>
                        <td>' . $nome . '</td>
                        <td><a href="cadastro/admin/' . $id . '" class="btn btn-success btn-sm">
                            <i class="fas fa-edit"></i></a>
                            
                            <a href="javascript:excluir('.$id.')" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i></a>
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
            location.href = "excluir/admin/" + id;
        }
    }
</script>