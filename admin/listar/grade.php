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
                <h1 class="m-0 text-dark">Grade</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="float-right">
        <a href="cadastro/grade" class="btn btn-outline-laranja">Novo Cadastro</a>
    </div>

    <div class="clearfix"></div>

    <div class="card-body table-responsive p-0 mt-3">
        <table id="tabDisciplina" class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Turma</th>
                    <th>Disciplina</th>
                    <th>Professor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT  g.id gid, g.*, t.*, d.*, p.*, pe.nome, pd.*
                    FROM grade g
                    INNER JOIN turma t ON (t.id = g.turma_id)
                    INNER JOIN disciplina d ON (d.id = g.disciplina_id)
                    INNER JOIN professor p ON (p.id = g.professor_id)
                    INNER JOIN pessoa pe ON (pe.id = p.pessoa_id)
                    INNER JOIN periodo pd ON (pd.id = t.periodo_id)";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    // Separar os dados
                    $id = $dados->gid;
                    $serie = $dados->serie;
                    $descricao = $dados->descricao;
                    $ano = $dados->ano;
                    $disciplina = $dados->disciplina;
                    $nome = $dados->nome;
                    $periodo = $dados->periodo;

                    echo '<tr>
                        <td> ' . $serie . ' ' . $descricao . ' / ' . $periodo . ' (' . $ano . ')</td>
                        <td>' . $disciplina . '</td>
                        <td> ' . $nome . '</td>
                        <td><a href="cadastro/grade/' . $id . '" class="btn btn-success btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <button type="button" class="btn btn-danger btn-sm" onclick="excluir(' . $id . ')">
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