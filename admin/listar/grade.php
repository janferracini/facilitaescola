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
                <h1 class="m-0 text-dark">Grade</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="float-right">
        <a href="cadastro/disciplina" class="btn btn-outline-laranja">Nova Disciplina</a>
    </div>

    <div class="clearfix"></div>

    <div class="card-body table-responsive p-0 mt-3">
        <table id="tabDisciplina" class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Disciplina</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php

            $sql = "SELECT  *
                    FROM disciplina
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
                        <td><a href="cadastro/disciplina/' . $id . '" class="btn btn-success btn-sm">
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
            location.href = "excluir/disciplina/" + id;
        }
    }
</script>