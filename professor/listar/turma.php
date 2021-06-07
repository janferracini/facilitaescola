<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 3) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <?php
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
        $consulta->bindParam("id", $id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);
        if (empty($dados->id)) {
            echo "<div class='pt-3'><p class='alert alert-danger'>Turma não encontrada</p></div>";
        } else {
            $id = $dados->gid;
            $serie = $dados->serie;
            $descricao = $dados->descricao;
            $ano = $dados->ano;
            $periodo = $dados->periodo;
            $professor = $dados->nome;
            $disciplina = $dados->disciplina;
            $turma_id = $dados->tid;
        }
        ?>
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Turma <?php echo  $serie . " " . $descricao . " / " . $periodo . " - " . $disciplina; ?></h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">
    <div class="card-body table-responsive p-0 mt-3">
        <table id="tabTurma" class="table ui celled table table-bordered table-hover">
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
                        WHERE t.id = $turma_id
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

<script>
    $(document).ready(function() {
        $("#tabTurma").DataTable({
            "language": {
                "search": "Filtrar ",
                "lengthMenu": "Mostrar _MENU_ resultados por página",
                "zeroRecords": "Registro não encontrado ",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "Registro não encontrado ",
                "infoFiltered": "(Busca feita em _MAX_ registros)",
                "paginate": {
                    "first": "Primeira",
                    "last": "Última",
                    "next": "PRÓXIMO",
                    "previous": "ANTERIOR"
                }
            }
        });
    })
</script>