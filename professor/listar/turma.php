<?php
// if (!isset($_SESSION['facilita_escola']['id'])) {
//     exit;
// }


?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <?php
        $sql = "SELECT  t.id tid, t.*, p.*
                    FROM turma t
                    INNER JOIN periodo p ON (t.periodo_id = p.id )
                    WHERE t.id = :id";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam("id", $id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);
        if (empty($dados->id)) {
            echo "<p class='alert alert-danger'> Turma não encontrada</p>";
            exit;
        } else {

            $id = $dados->tid;
            $serie = $dados->serie;
            $descricao = $dados->descricao;
            $ano = $dados->ano;
            $periodo = $dados->periodo;
        }
        ?>
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Alunos <?php echo  $serie . " " . $descricao . " / " . $periodo; ?></h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">
    <div class="card-body table-responsive p-0 mt-3">
        <table id="tabAluno" class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th width=200px>Matrícula</th>
                    <th width=200px>Contato</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT t.id tid, t.*, tm.*, m.pessoa_id, m.matricula, pe.nome, pe.telefone1
                        FROM turma t
                        INNER JOIN turma_matricula tm ON (tm.turma_id = t.id)
                        INNER JOIN matricula m ON (m.id = tm.matricula_id)
                        INNER JOIN pessoa pe ON (pe.id = m.pessoa_id)
                        WHERE t.id = $id
                        ORDER BY pe.nome";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $nome = $dados->nome;
                    $matricula = $dados->matricula;
                    $telefone = $dados->telefone1;

                    echo '<tr>
                            <td>' . $nome . '</td>
                            <td>' . $matricula . '</td>
                            <td>' . $telefone . '</td>
                        </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

</div>