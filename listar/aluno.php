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
                <h1 class="m-0 text-dark">Alunos Cadastrados</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="float-right">
        <a href="cadastro/aluno" class="btn btn-success">Novo Registro</a>
        <a href="listar/aluno" class="btn btn-info">Listar Registro</a>
    </div>

    <div class="clearfix"></div>

    <div class="card-body table-responsive p-0 mt-3">
        <table id="tabTurma" class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>CGM</th>
                    <th>Nome</th>
                    <th>Período</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php

            $sql = "SELECT  a.id,
                            a.matricula,
                            p.id,
                            p.nome,
                            a.serie,
                    FROM aluno a
                    INNER JOIN pessoa p ON (p.id = a.pessoa_id)
                    ORDER BY aluno";
                    
            $consulta = $pdo->prepare($sql);
            $consulta->execute();

            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                // Separar os dados
                $id = $dados->id;
                $matricula = $dados->matricula;
                $pessoa_id = $dados->pessoa_id;
                $nome = $dados->nome;
                $serie = $dados->serie;
                $periodo = $dados->periodo;

                // Mostrar na tela
                echo '<tr>
                        <td>' . $matricula . '</td>
                        <td>' . $nome . '</td>
                        <td>' . $serie . '</td>
                        <td>' . $periodo . '</td>
                        <td><a href="cadastro/aluno/' . $id . '" class="btn btn-success btn-sm">
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
            location.href = "excluir/turma/" + id;
        }
    }
</script>