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
                <h1 class="m-0 text-dark">Alunos Cadastrados</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="float-right">
        <a href="cadastro/aluno" class="btn btn-outline-laranja">Novo Aluno</a>
    </div>

    <div class="clearfix"></div>

    <div class="card-body table-responsive p-0 mt-3">
        <table id="tabAluno" class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th width=20%>Matrícula</th>
                    <th width=20%>Turma / Período</th>
                    <th width=20%>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT  p.id pid, p.nome, m.*, tm.*, t.*, pe.*
                    FROM pessoa p
                    INNER JOIN matricula m ON (m.pessoa_id = p.id)
                    INNER JOIN turma_matricula tm ON (tm.matricula_id = m.id)
                    INNER JOIN turma t ON (t.id = tm.turma_id)
                    INNER JOIN periodo pe ON (pe.id = t.periodo_id)
                    WHERE p.tipo_cadastro = 2 AND p.status = 1
                    ORDER BY nome";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $id      = $dados->pid;
                    $nome    = $dados->nome;
                    $matricula = $dados->matricula;
                    $serie   = $dados->serie;
                    $periodo = $dados->periodo;

                    echo '<tr>
                        <td>' . $nome . '</td>
                        <td>' . $matricula . '</td>
                        <td>' . $serie . ' / ' . $periodo . '</td>
                        <td><a href="cadastro/aluno/' . $id . '" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="inativar(' . $id . ')">
                                <i class="fas fa-times-circle"></i>
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
    function inativar(id) {
        //perguntar
        if (confirm("Deseja mesmo inativar?")) {
            //direcionar para exclusão
            location.href = "excluir/aluno/" + id;
        }
    }
</script>