<?php
//verificar se não está logado
// if (!isset($_SESSION["hqs"]["id"])) {
//     exit;
// }

if (!isset($id)) $id = "";

// tabela arquivo
$descricao = $arquivo = $data_postagem = $grade_id  = "";
// tabela grade
$turma_id = "";
// tabela turma
$serie = $descricao = $ano = $periodo_id = "";
// tabela periodo
$periodo = "";

if (!empty($id)) {
    //select nos dados do cliente
    $sql = "SELECT a.id aid, a.*, g.id gid, g.turma_id tid, t.*, 
                p.id pid, p.*
            FROM atividade a
            INNER JOIN grade g ON (g.id = a.grade_id) 
            INNER JOIN turma t ON (t.id = g.turma_id) 
            INNER JOIN periodo p ON (p.id = t.periodo_id)
            WHERE a.id = :id
            LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id)) {
        echo "<p class='alert alert-danger'>Não há ativadades a serem listadas.</p>";
    }

    $id         = $dados->aid;
    $descricao  = $dados->descricao;
    $arquivo    = $dados->arquivo;
    // tabela grade
    $grade_id   = $dados->gid;
    // tabela periodo
    $periodo    = $dados->periodo;
    $periodo_id = $dados->pid;
    // tabela turma
    $turma_id  = $dados->tid;
    $serie     = $dados->serie;
    $ano       = $dados->ano;
    $data_postagem = $dados->data_postagem;
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

            <!-- selecionar a turma -->
            <div class="col-12 ">
                <label for="turma">Turma</label>
                <input type="hidden" class="form-control" name="tid" id="tid" readonly value="<?= $turma_id ?>">
                <input id="grade_id" name="grade_id" class="form-control" list="listaTurma" data-parsley-required-message="Selecione a turma" value="<?php if (!empty($id)) echo "$turma_id - $serie $descricao / $periodo ($ano)"; ?>">
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
                        echo '<option value="' . $serie . ' ' . $descricao . ' / ' . $periodo . ' (' . $ano . ')">';
                    };
                    ?>
                </datalist>
            </div>

            <div class="col-sm-12">
                <label for="atividade">Atividade:</label>
                <textarea type="text" name="atividade" id="atividade" class="form-control" required data-parsley-required-message="Preencha a descrição da atividade" value="<?= $atividade ?>" placeholder="Informe a descrição da atividade"></textarea>
            </div>

            <div class="col-sm-12">
                <label for="arquivo">Arquivo:</label>
                <input type="file" name="arquivo" id="arquivo" class="form-control" accept=".jpg, .jpeg, .docx, .pdf" required data-parsley-required-message="Selecione o arquivo" value="<?= $arquivo ?>" placeholder="Selecione o arquivo da atividade">
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