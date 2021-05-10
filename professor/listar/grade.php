<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Turmas</h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="row">
    <?php
    $idprofessor = $_SESSION["facilita_escola"]["id"];
    $sql = "SELECT  g.id idgrade, g.*,
                        t.*,
                        pd.*, 
                        d.*, 
                        p.id, 
                        pe.id 
                FROM grade g
                INNER JOIN turma t ON (t.id = g.turma_id)
                INNER JOIN periodo pd ON (pd.id = t.periodo_id)
                INNER JOIN disciplina d ON (d.id = g.disciplina_id)
                INNER JOIN professor p ON (p.id = g.professor_id)
                INNER JOIN pessoa pe ON (pe.id = p.pessoa_id)
                WHERE p.pessoa_id = $idprofessor
                ORDER BY t.descricao";

    $consulta = $pdo->prepare($sql);
    $consulta->execute();

    while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {

        $id = $dados->idgrade;
        $turma = $dados->serie;
        $descricao = $dados->descricao;
        $periodo = $dados->periodo;
        $disciplina = $dados->disciplina;

        echo "<div class='col-12 col-sm- col-md-3'>
                <a href='listar/turma/" . $id . "'><div class='info-box text-center'>
                    <span class='info-box-icon  elevation-1'>
                        <i class='fas fa-chalkboard'></i>
                    </span>
                    <div class='info-box-content'>
                        
                            <span class='info-box-text'><strong>" . $disciplina . "</strong></span>
                            " . $turma . " " . $descricao . "  - " . $periodo . "
                        
                    </div>
                </div></a>
            </div>";
    }
    ?>


</div>