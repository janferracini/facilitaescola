<?php
//verificar se não está logado
// if (!isset($_SESSION["hqs"]["id"])) {
//     exit;
// }

if (!isset($id)) $id = "";

// tabela recado
$titulo = $conteudo = $data_postagem = $turma_id  = '';
// tabela turma
$serie = $descricao = $ano = $periodo_id = '';

if (!empty($id)) {
    //select nos dados  
    $sql = "SELECT  *
            FROM recado r
            INNER JOIN turma t ON (t.id = r.turma_id)
            WHERE r.id = :id
            LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    // fazer a listagem de recados 
    if (empty($dados->id)) {
        echo "<p class='alert alert-danger'>Não há recados a serem listadas.</p>";
    }

    $id            = $dados->id;
    $titulo        = $dados->titulo;
    $conteudo      = $dados->conteudo;
    $data_postagem = $dados->data_postagem;
    $turma_id      = $dados->turma_id;
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Cadastro de Recados</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container">

    <div class="float-right">
        <a href="listar/recado" class="btn btn-outline-info">Listar Recados</a>
    </div>

    <div class="clearfix"></div> <!-- Ignora os floats -->


    <form action="salvar/recado" name="formCadastro" method="post" data-parsley-validate enctype="multipart/form-data" role="form">

        <div class="row mb-3">

            <div class="col-sm-12">
                <label for="titulo"> Título: </label>
                <input type="text" id="titulo" name="titulo" class="form-control" required data-parsley-required-message="Preencha o título do recado" placeholder="Informe o título do recado">
            </div>

            <div class="col-sm-12">
                <label for="conteudo"> Conteúdo: </label>
                <textarea type="text" name="conteudo" id="conteudo" class="form-control" required data-parsley-required-message="Informe o conteúdo referente ao recado" placeholder=""></textarea>
            </div>

            <!-- envio para qual turma será -->
            <div class="form-group">
                <label for="turma">Turma</label>
                <input type="text" name="turma_id" id="turma_id" class="form-control" list="listaTurma" data-parsley-required-message="Selecione a turma" value="<?php
                                                                                                                                                                    if (!empty($grade_id)) echo "$turma - $grade_id";
                                                                                                                                                                    ?>">
                <datalist id="listaTurma">
                    <?php
                    $sql = "SELECT id, serie, descricao, ano, periodo_id
                                    FROM turma
                                    ORDER BY id";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ($d = $consulta->fetch(PDO::FETCH_OBJ)) {
                        //separar os dados
                        $turma_id    = $dados->id;
                        $serie       = $dados->serie;
                        $descricao   = $dados->descricao;
                        $ano         = $dados->ano;
                        $periodo_id  = $dados->periodo_id;

                        echo '<option value=" ' . $turma . ' - ' . $turma_id . ' - ' . $serie . ' - ' . $descricao . ' - ' . $ano . ' - ' . $periodo_id . '">';
                    };
                    ?>
                </datalist>
            </div>

        </div>

        <button type="submit" class="btn btn-outline-laranja">
            <i class="fas fa-check"></i> Gravar Dados
        </button>
    </form>

</div>