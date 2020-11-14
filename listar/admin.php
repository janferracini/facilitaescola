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
                <h1 class="m-0 text-dark">Equipe Administrativa </h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="float-right">
        <a href="cadastro/turma" class="btn btn-success">Novo Administrador</a>
        <a href="listar/turma" class="btn btn-info">Listar Administradores</a>
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

            

                // Mostrar na tela
                echo '<tr>
                        <td>' . 1 . '</td>
                        <td>' . "Janaina Ferracini" . '</td>
                        
                        <td><a href="cadastro/turma/' . 1 . '" class="btn btn-success btn-sm">
                            <i class="fas fa-edit"></i></a>
                            
                            <a href="javascript:excluir('. 1 .')" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i></a>
                        </td>
                    </tr>';

                echo '<tr>
                        <td>' . 3 . '</td>
                        <td>' . "Camila Fonte" . '</td>
                        
                        <td><a href="cadastro/turma/' . 1 . '" class="btn btn-success btn-sm">
                            <i class="fas fa-edit"></i></a>
                            
                            <a href="javascript:excluir('. 1 .')" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i></a>
                        </td>
                    </tr>';
                echo '<tr>
                        <td>' . 4 . '</td>
                        <td>' . "Vinicius Cerezuela" . '</td>
                        
                        <td><a href="cadastro/turma/' . 1 . '" class="btn btn-success btn-sm">
                            <i class="fas fa-edit"></i></a>
                            
                            <a href="javascript:excluir('. 1 .')" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i></a>
                        </td>
                    </tr>';
            //}

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