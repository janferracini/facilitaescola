<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if (!isset($id)) $id = "";
$disciplina = '';

if (!empty($id)) {
    //select nos dados do disciplina
    $sql = "SELECT  *
            FROM disciplina
            WHERE id = :id
            LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id)) {
        echo "<p class='alert alert-danger'>Disciplina não existe</p>";
    }

    $id             = $dados->id;
    $disciplina     = $dados->disciplina;
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Cadastro de Disciplina</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container">

    <div class="float-right">
        <a href="listar/disciplina" class="btn btn-outline-info">Listar Disciplinas</a>
    </div>

    <div class="clearfix"></div> <!-- Ignora os floats -->

    <form action="salvar/disciplina" name="formCadastro" method="post" data-parsley-validate enctype="multipart/form-data" role="form">
        <div class="row mb-3">
            <div class="col-sm-12">
                <input type="hidden" class="form-control" name="id" id="id" readonly value="<?= $id ?>">
                <label for="disciplina">Disciplina:</label>
                <input type="text" autocomplete="off" name="disciplina" id="disciplina" class="form-control" required data-parsley-required-message="Preencha a Disciplina" value="<?= $disciplina ?>" placeholder="Digite a Disciplina">
            </div>

        </div>

        <div class="float-right">
            <button type="submit" class="btn btn-outline-laranja margin">
                <i class="fas fa-check"></i> Gravar Dados
            </button>
        </div>
        <div class="clearfix"></div> <!-- Ignora os floats -->
    </form>

</div>