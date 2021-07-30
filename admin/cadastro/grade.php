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
    $sql = "SELECT  g.id gid, g.*, 
                    t.id tid, t.*, 
                    d.id did, d.*, 
                    pr.id pid, pr.*,
                    p.nome,
                    pe.periodo
            FROM grade g
            INNER JOIN turma t ON (t.id = g.turma_id)
            INNER JOIN disciplina d ON (d.id = g.disciplina_id)
            INNER JOIN professor pr ON (pr.id = g.professor_id)
            INNER JOIN pessoa p ON (p.id = pr.pessoa_id)
            INNER JOIN periodo pe ON (pe.id = t.periodo_id)
            WHERE g.id = :id
            LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id)) {
        echo "<div class='pt-3'><p class='alert alert-danger'>Cadastro não existe</p></div>";
        print_r($sql);
        exit;
    } else {
        $id             = $dados->gid;
        $disciplina     = $dados->disciplina;
        $professor      = $dados->nome;
        $professor_id   = $dados->pid;
        $turma_id       = $dados->turma_id;
        $serie          = $dados->serie;
        $descricao      = $dados->descricao;
        $ano            = $dados->ano;
        $periodo        = $dados->periodo;
        $disciplina_id  = $dados->did;
    }
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Cadastro da Grade</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">

    <div class="float-right">
        <a href="listar/grade" class="btn btn-outline-info">Listrar Cadastros</a>
    </div>

    <div class="clearfix"></div>

    <form action="salvar/grade" name="formCadastro" method="post" data-parsley-validate enctype="multipart/form-data" role="form">
        <div class="row mb-3">
            <input type="hidden" class="form-control" name="id" id="id" readonly value="<?= $id ?>">

            <div class="col-12 col-md-4">
                <label for="turma">Turma</label>
                <input type="hidden" class="form-control" name="tid" id="tid" readonly value="<?= $turma_id ?>">
                <input id="turma_id" name="turma_id" class="form-select" list="listaTurma" required data-parsley-required-message="Selecione a turma" value="<?php if (!empty($id)) echo "$turma_id - $serie $descricao / $periodo ($ano)"; ?>">
                <datalist id="listaTurma">
                    <?php
                    $sql = "SELECT t.*,t.id tid, p.*
                            FROM turma t
                            INNER JOIN periodo p ON (p.id = t.periodo_id)
                            ORDER BY serie";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
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

            <div class="col-12 col-md-4">
                <label for="disciplina">Disciplina</label>
                <input type="hidden" class="form-control" name="disciplina_id" id="disciplina_id" readonly value="<?= $disciplina_id ?>">
                <input id="disciplina_id" name="disciplina_id" class="form-select" list="listaDisciplina" required data-parsley-required-message="Selecione a Disciplina" value="<?php if (!empty($id)) echo "$disciplina"; ?>">
                <datalist id="listaDisciplina">
                    <?php
                    $sql = "SELECT d.id did, d.*
                            FROM disciplina d
                            ORDER BY disciplina";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                        $did     = $dados->did;
                        $disciplina = $dados->disciplina;
                        echo '<option value=" ' . $did . ' - ' . $disciplina . '">';
                    };
                    ?>
                </datalist>
            </div>

            <div class="col-12 col-md-4">
                <label for="professor">Professor</label>
                <input type="hidden" class="form-control" name="professor_id" id="professor_id" readonly value="<?= $professor_id ?>">
                <input id="professor_id" name="professor_id" class="form-select" list="listaProfessor" required data-parsley-required-message="Selecione o Professor" value="<?php if (!empty($id)) echo "$professor_id - $professor"; ?>">
                <datalist id="listaProfessor">
                    <?php
                    $sql = "SELECT p.id, p.nome, pr.id, pr.pessoa_id
                                        FROM professor pr
                                        INNER JOIN pessoa p ON (p.id = pr.pessoa_id)
                                        ORDER BY p.nome";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                        $pid     = $dados->id;
                        $nome = $dados->nome;
                        echo '<option value=" ' . $pid . ' - ' . $nome . '">';
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
        <div class="clearfix"></div>
    </form>
</div>