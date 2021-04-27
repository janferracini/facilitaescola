<?php
//verificar se não está logado
// if (!isset($_SESSION["hqs"]["id"])) {
//     exit;
// }

if (!isset($id)) $id = "";

// tabela arquivo
$descricao = $arquivo = $data_postagem = $grade_id  = '';
// tabela turma
$serie = $descricao = $ano = $periodo_id = '';

if (!empty($id)) {
    //select nos dados do cliente
    $sql = "SELECT  *
            FROM arquivo a
            INNER JOIN grade g ON (g.id = a.grade_id)
            WHERE p.id = :id
            LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id)) {
        echo "<p class='alert alert-danger'>Não há ativadades a serem listadas.</p>";
    }

    $id            = $dados->id;
    $descricao     = $dados->descricao;
    $arquivo       = $dados->arquivo;
    $data_postagem = $dados->data_postagem;
    $grade_id      = $dados->grade_id;

}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Cadastro de Atividade</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container">

    <div class="float-right">
        <a href="listar/atividade" class="btn btn-outline-info">Listar Atividades</a>
    </div>

    <div class="clearfix"></div> <!-- Ignora os floats -->


    <form action="salvar/atividade" name="formCadastro" method="post" data-parsley-validate enctype="multipart/form-data" role="form">

        <div class="row mb-3">

            <div class="col-sm-12">
                <label for="grade_id"> Selecione a turma: </label>
                <input type="text" id="turma" name="turma" class="form-control" 
                required data-parsley-required-message="Selecione uma turma" placeholder="Selecione a turma desejada">
            </div>

            <div class="col-sm-12">
                <label for="atividade"> Atividade: </label>
                <textarea type="text" id="atividade" name="atividade" class="form-control" 
                required data-parsley-required-message="Preencha a descrição da atividade" placeholder="Insira a descrição da atividade"></textarea>
            </div>
            
            <div class="col-sm-12">
                <label for="arquivo">Arquivo:</label>
                <input type="file" name="arquivo" id="arquivo" class="form-control" accept=".jpg, .jpeg, .docx, .pdf"
                required data-parsley-required-message="Selecione o arquivo" 
                value="<?= $arquivo ?>" placeholder="Selecione o arquivo a atividade">
            </div>

        </div>

        <button type="submit" class="btn btn-outline-laranja">
            <i class="fas fa-check"></i> Gravar Dados
        </button>
    </form>

</div>