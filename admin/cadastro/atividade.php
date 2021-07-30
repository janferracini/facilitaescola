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

$descricao = $arquivo = $data_postagem = $grade_id  = "";
$turma_id = "";
$serie = $descricao = $ano = $periodo_id = "";
$periodo = "";

if (!empty($id)) {
    $sql = "SELECT a.id aid, a.*, g.id gid, g.turma_id tid, t.*, 
                p.id pid, p.*, d.*, pr.*, pe.id, pe.nome
            FROM atividade a
            INNER JOIN grade g ON (g.id = a.grade_id) 
            INNER JOIN disciplina d ON (d.id = g.disciplina_id)
            INNER JOIN turma t ON (t.id = g.turma_id) 
            INNER JOIN periodo p ON (p.id = t.periodo_id)
            INNER JOIN professor pr ON (pr.id = g.professor_id)
            INNER JOIN pessoa pe ON (pe.id = pr.pessoa_id)
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
    $atividade  = $dados->atividade;
    $arquivo    = $dados->arquivo;
    $grade_id   = $dados->gid;
    $periodo    = $dados->periodo;
    $periodo_id = $dados->pid;
    $turma_id  = $dados->tid;
    $ano       = $dados->ano;
    $data_postagem = $dados->data_postagem;
    $disciplina = $dados->disciplina;
    $serie = $dados->serie;
    $professor = $dados->nome;
    $descricao = $dados->descricao;
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Cadastro de Atividade</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="float-right">
        <a href="listar/atividade" class="btn btn-outline-info">Listar Atividades</a>
    </div>
    <div class="clearfix"></div>
    <form action="salvar/atividade" name="formCadastro" method="post" data-parsley-validate enctype="multipart/form-data" role="form">
        <div class="row mb-3">
            <div class="col-12 ">
                <label for="turma">Grade</label>
                <input type="hidden" class="form-control" name="id" id="id" readonly value="<?= $id ?>">
                <input id="grade_id" autocomplete="off" name="grade_id" class="form-control" autocomplete="off" list="listaTurma" data-parsley-required-message="Selecione a grade" value="<?php if (!empty($id)) echo "$grade_id - $disciplina - $serie $descricao / $periodo ($professor)"; ?>">
                <datalist id="listaTurma">
                    <?php
                    $sql = "SELECT  g.id idgrade, g.*, t.*, pd.*, d.*, p.id, pe.id , pe.nome
                            FROM grade g
                            INNER JOIN turma t ON (t.id = g.turma_id)
                            INNER JOIN periodo pd ON (pd.id = t.periodo_id)
                            INNER JOIN disciplina d ON (d.id = g.disciplina_id)
                            INNER JOIN professor p ON (p.id = g.professor_id)
                            INNER JOIN pessoa pe ON (pe.id = p.pessoa_id)
                            WHERE g.status = 1
                            ORDER BY t.descricao ASC";

                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {

                        $grade_id = $dados->idgrade;
                        $serie = $dados->serie;
                        $descricao = $dados->descricao;
                        $periodo = $dados->periodo;
                        $disciplina = $dados->disciplina;
                        $professor = $dados->nome;
                        echo '<option value="' . $grade_id . ' - ' . $disciplina . ' - ' . $serie . ' ' . $descricao . ' / ' . $periodo . ' (' . $professor . ')">';
                    };
                    ?>
                </datalist>
            </div>
            <div class="col-sm-12">
                <label for="atividade">Atividade:</label>
                <textarea type="text" maxlength="1024" name="atividade" id="atividade" class="form-control" required data-parsley-required-message="Preencha a descrição da atividade" placeholder="Informe a descrição da atividade"><?php if (!empty($id)) echo $atividade ?></textarea>
            </div>
            <div class="col-sm-12">
                <?php
                $r = 'required data-parsley-required-message="Selecione uma foto"';

                if (!empty($id)) $r = '';
                ?>
                <label for="arquivo">Arquivo: </label>
                <spam>(Tipos permitidos: .jpg, .jpeg, .doc, .docx, .odt ou .pdf, tamanho máximo: 3Mb)</spam>
                <input type="hidden" name="arquivo" value="<?= $arquivo; ?>">
                <input type="file" name="arquivo" id="arquivo" class="form-control" accept=".jpg, .jpeg, .docx, .pdf, .doc, .odt" <?= $r; ?> placeholder="Selecione o arquivo da atividade">
            </div>

            <?php
            if (!empty($id)) {
                echo "<div class='col-sm-12 mt-2'>
                <p>Arquivo já encaminhado: <a href='../atividades/$arquivo' download='Atividade $disciplina-$serie $descricao($periodo)'>Download</a></p>
                </div>";
            }
            ?>
        </div>
        <div class="float-right">
            <button type="submit" class="btn btn-outline-laranja margin">
                <i class="fas fa-check"></i> Gravar Dados
            </button>
        </div>
        <div class="clearfix"></div>
    </form>
</div>