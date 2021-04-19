<?php
if (!isset($_SESSION['facilita_escola']['id'])) {
    exit;
}

$sql = "SELECT t.*, p.*, tm.*, m.pessoa_id, pe.nome
        FROM turma t
        INNER JOIN periodo p ON (p.id = t.periodo_id)
        INNER JOIN turma_matricula tm ON (tm.turma_id = t.id)
        INNER JOIN matricula m ON (m.id = tm.matricula_id)
        INNER JOIN pessoa pe ON (pe.id = m.pessoa_id)
        WHERE id = $id";

$consulta = $pdo->prepare($sql);
$consulta->execute();

while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
    $id = $dados->id;
    $serie = $dados->serie;
    $descricao = $dados->descricao;
    $periodo = $dados->periodo;
    $disciplina = $dados->disciplina;
} ?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Alunos Turma <?php echo "$serie " - " $descricao " - " $periodo" ?></h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

</div>