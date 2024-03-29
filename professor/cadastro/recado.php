<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 3) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
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

$idprofessor = $_SESSION["facilita_escola"]["id"];

if (!empty($id)) {
    //select nos dados  
    $sql = "SELECT r.id rid, r.*, g.id gid, g.*, t.id tid, t.*, p.id pid, p.*
            FROM recado r 
            INNER JOIN grade g ON (g.id = r.grade_id)
            INNER JOIN turma t ON (t.id = g.turma_id) 
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
    $grade_id      = $dados->gid;
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
                <input type="text" id="titulo" maxlength="60" minlength="12" name="titulo" class="form-control" required data-parsley-required-message="Preencha o título do recado" placeholder="Informe o título do recado" value="<?= $titulo ?>">
            </div>

            <div class="col-sm-12">
                <label for="conteudo"> Conteúdo: </label>
                <textarea type="text" name="conteudo" id="conteudo" class="form-control" required data-parsley-required-message="Informe o conteúdo referente ao recado" placeholder="Insira a descrição do recado"><?php if (!empty($id)) echo $conteudo ?></textarea>
            </div>

            <!-- selecionar a turma -->
            <div class="col-12">
                <label for="grade">Grade</label>
                <input type="hidden" class="form-control" name="gid" id="gid" readonly value="<?= $grade_id ?>">
                <input id="grade_id" name="grade_id" autocomplete="off" class="form-control" list="listaTurma" required data-parsley-required-message="Selecione a turma" value="<?php if (!empty($id)) echo "$grade_id - $serie $descricao / $periodo ($ano)"; ?>">
                <datalist id="listaTurma">
                    <?php

                    $sql = "SELECT  g.id gid, g.*, t.id tid, t.*, pd.*, d.*, p.id, pe.id 
                            FROM grade g
                            INNER JOIN turma t ON (t.id = g.turma_id)
                            INNER JOIN periodo pd ON (pd.id = t.periodo_id)
                            INNER JOIN disciplina d ON (d.id = g.disciplina_id)
                            INNER JOIN professor p ON (p.id = g.professor_id)
                            INNER JOIN pessoa pe ON (pe.id = p.pessoa_id)
                            WHERE p.pessoa_id = $idprofessor";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();
                    while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                        // separar os dados
                        $serie     = $dados->serie;
                        $descricao = $dados->descricao;
                        $ano       = $dados->ano;
                        $periodo   = $dados->periodo;
                        $grade_id  = $dados->gid;
                        echo ' <option value="' . $grade_id . ' - ' . $serie . ' ' . $descricao . ' / ' . $periodo . '">';
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