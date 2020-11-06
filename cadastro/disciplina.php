<?php

if (!isset($id)) $id = "";

$disciplina = "";

if (!empty($id)) {
    $sql = "SELECT id, disciplina
            FROM disciplina
            WHERE id = :id
            LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id)) {
        echo "<p class='alert alert-danger'> Disciplina não cadastrada</p>";
    }

    $id = $dados->id;
    $disciplina = $dados->disciplina;
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Cadastro de Disciplinas</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<div class="container">
    <div class="float-right">
        <a href="cadastro/disciplina" class="btn btn-success">Nova Disciplina</a>
        <a href="listar/disciplina" class="btn btn-info">Listar Disciplinas</a>
    </div>

    <div class="clearfix"></div> <!-- Ignora os floats -->

    <form action="salvar/disciplina" name="formDisciplina" method="post" data-parsley-validate enctype="multipart/form-data" role="form">
        <div class="row mb-3">
        
            <div class="col-sm-8">
                <label for="descricao">Disciplina</label>
                <input type="text" id="disciplina" name="disciplina" class="form-control" 
                required data-parsley-required-message="Preencha a Disciplina" placeholder="Nome da disciplina" value="<?= $disciplina ?>">
            </div>

        </div>

        <button type="submit" class="btn btn-success margin">
            <i class="fas fa-check"></i> Gravar Dados
        </button>
    </form>

</div>