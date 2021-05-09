<?php
//verificar se não está logado
// if (!isset($_SESSION["hqs"]["id"])) {
//     exit;
// }

if (!isset($id)) $id = "";

// tabela recado
$titulo = $conteudo = $grade_id  = "";
// tabela grade
$turma_id = "";
// tabela turma
$serie = $descricao = $ano = $periodo_id = "";
// tabela periodo
$periodo = "";


if (!empty($id)) {
    //select nos dados  
    $sql = "SELECT r.id rid, r.*, g.id gid, g.turma_id tid, 
            t.*
            FROM recado r
            -- alterar para enviar na grade e quem enviou
            INNER JOIN turma t ON (t.id = g.turma_id) 
            INNER JOIN grade g ON (g.id = r.grade_id) 
            WHERE r.id = :id
            LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id)) {
        echo "<p class='alert alert-danger'>Recado inexistente.</p>";
    }

    // fazer a listagem de recados 
    // tabela recado
    $id            = $dados->rid;
    $titulo        = $dados->titulo;
    $conteudo      = $dados->conteudo;
    // tabela grade
    $grade_id      = $dados->gid;
    // tabela periodo
    $periodo       = $dados->periodo;
    $periodo_id    = $dados->pid;
    // tabela turma
    $turma_id      = $dados->tid;
    $serie         = $dados->serie;
    $descricao     = $dados->descricao;
    $ano           = $dados->turma;
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
                <input type="text" id="titulo" name="titulo" class="form-control" required data-parsley-required-message="Preencha o título do recado" placeholder="Informe o título do recado" value="<?= $titulo ?>">
            </div>

            <div class="col-sm-12">
                <label for="conteudo"> Conteúdo: </label>
                <textarea type="text" name="conteudo" id="conteudo" class="form-control" required data-parsley-required-message="Informe o conteúdo referente ao recado" placeholder="Insira a descrição do recado" value="<?= $conteudo ?>"></textarea>
            </div>

            <div class=" col-12">
                <!-- envio para qual turma será -->
                <label for="turma_id"> Turma: </label>
                <input type="hidden" class="form-control" name="trid" value="<?= $turma_recado_id ?>">
                <select name="grade_id" id="grade_id" class="form-control" value="<?= $grade_id ?>">
                    <option value="">Selecione a turma</option>

                    <?php
                    $sql = "SELECT serie, descricao, ano, p.periodo
                            FROM turma t
                            INNER JOIN periodo p ON (p.id = t.periodo_id)
                            ORDER BY serie";

                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                        //separar os dados
                        $serie       = $dados->serie;
                        $descricao   = $dados->descricao;
                        $ano         = $dados->ano;
                        $periodo     = $dados->periodo;

                        echo "<option> $serie $descricao - $periodo ($ano)</option>";
                    }
                    ?>
                </select>

            </div>
        </div>

        <div class="float-right">
            <button type="submit" class="btn btn-outline-laranja margin">
                <i class="fas fa-check"></i> Gravar Dados
            </button>
        </div>
        <div class="clearfix"></div> <!-- Ignora os floats -->
    </form>

    <?php if (empty($id)) $id = 0; //verificar se id é vazio 
    ?>

</div>