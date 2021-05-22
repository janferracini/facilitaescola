<?php
//verificar se não está logado
if (!isset($_SESSION["facilita_escola"]["id"])) {
    exit;
}

if (!isset($id)) $id = "";

// tabela recado
$titulo = $conteudo = $turma_id  = "";
// tabela grade
$turma_id = "";
// tabela turma
$serie = $descricao = $ano = $periodo_id = "";
// tabela periodo
$periodo = "";

if (!empty($id)) {
    //select nos dados  
    $sql = "SELECT r.id rid, r.*, t.id tid, t.*, p.id pid, p.*
            FROM recado r 
            INNER JOIN turma t ON (t.id = r.turma_id) 
            INNER JOIN periodo p ON (p.id = t.periodo_id)
            WHERE r.id = :id
            LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id)) {
        echo "<p class='alert alert-danger'>Recado inexistente.</p>";
        //exit;
    }
    // fazer a listagem de recados se id nao estiver vazio
    // tabela recado
    $id            = $dados->rid;
    $titulo        = $dados->titulo;
    $conteudo      = $dados->conteudo;
    // tabela periodo
    $periodo       = $dados->periodo;
    $periodo_id    = $dados->pid;
    // tabela turma
    $turma_id      = $dados->tid;
    $serie         = $dados->serie;
    $descricao     = $dados->descricao;
    $ano           = $dados->ano;
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
            <input type="hidden" class="form-control" name="id" id="id" readonly value="<?= $id ?>">

            <div class="col-sm-12">
                <label for="titulo"> Título: </label>
                <input type="text" autocomplete="off" id="titulo" name="titulo" class="form-control" required data-parsley-required-message="Preencha o título do recado" placeholder="Informe o título do recado" value="<?= $titulo ?>">
            </div>

            <div class="col-sm-12">
                <label for="conteudo"> Conteúdo: </label>
                <textarea type="text" name="conteudo" id="conteudo" class="form-control" required data-parsley-required-message="Informe o conteúdo referente ao recado" placeholder="Insira a descrição do recado"><?php if (!empty($id)) echo $conteudo ?></textarea>
            </div>

            <!-- selecionar a turma -->
            <div class="col-12">
                <label for="turma">Turma</label>
                <input type="hidden" class="form-control" name="tid" id="tid" readonly value="<?= $turma_id ?>">
                <input id="turma_id" autocomplete="off" name="turma_id" class="form-control" list="listaTurma" data-parsley-required-message="Selecione a turma" value="<?php if (!empty($id)) echo "$turma_id - $serie $descricao / $periodo ($ano)"; ?>">
                <datalist id="listaTurma">
                    <?php
                    $sql = "SELECT t.*,t.id tid, p.*
                                        FROM turma t
                                        INNER JOIN periodo p ON (p.id = t.periodo_id)
                                        ORDER BY serie";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                        // separar os dados
                        $serie     = $dados->serie;
                        $descricao = $dados->descricao;
                        $ano       = $dados->ano;
                        $periodo   = $dados->periodo;
                        $turma_id  = $dados->tid;
                        echo '<option value=" ' . $turma_id . ' - ' . $serie . ' ' . $descricao . ' / ' . $periodo . ' (' . $ano . ')">';
                    };
                    ?>
                </datalist>
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