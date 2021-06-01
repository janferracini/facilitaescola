<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 2) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

$idaluno = $_SESSION['facilita_escola']['id'];
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Atividades Cadastradas</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">
    <div class="card-body p-0 mt-3 pb-3">
        <table id="tabAtividade" class="table ui celled table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 20%;">Data de Postagem</th>
                    <th style="width: 30%;">Atividade</th>
                    <th style="width: 30%;">Disciplina</th>
                    <th style="width: 20%;">Salvar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT a.id aid, a.atividade, a.arquivo, a.grade_id, date_format(a.data_postagem, '%d/%m/%Y') data_postagem,
                                g.*, t.*, p.*, d.*, t.*, tm.*, m.*, pe.id
                        FROM atividade a
                        INNER JOIN grade g ON ( a.grade_id = g.id) 
                        INNER JOIN disciplina d ON (d.id = g.disciplina_id)
                        INNER JOIN turma t ON (t.id = g.turma_id) 
                        INNER JOIN periodo p ON (p.id = t.periodo_id)
                        INNER JOIN turma_matricula tm ON (tm.turma_id = t.id)
                        INNER JOIN matricula m ON (tm.matricula_id)
                        INNER JOIN pessoa pe ON (pe.id = m.pessoa_id)
                        WHERE pe.id = $idaluno
                        GROUP BY aid DESC";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    //atividade
                    $id         = $dados->aid;
                    $atividade  = $dados->atividade;
                    $arquivo    = $dados->arquivo;
                    $data       = $dados->data_postagem;
                    //discilina
                    $disciplina = $dados->disciplina;
                    //turma
                    $serie      = $dados->serie;
                    $descricao  = $dados->descricao;
                    //periodo
                    $periodo    = $dados->periodo;

                    echo '<tr>
                <td>' . $data . '</td>
                <td>' . substr($atividade, 0, 50) . '</td>
                <td>' . $disciplina . ' </td>
                <td>
                <a href="../atividades/' . $arquivo . '" download="Atividade de ' . $disciplina . '(' . $data . ')" class="btn btn-outline-laranja btn-sm">
                <i class="fas fa-arrow-down"></i>
                    </a>
                </td>
                </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<script>
    //função para perguntar se deseja excluir. Se sim, direcionar para o endereço de exclusão
    function excluir(id) {
        //perguntar
        if (confirm("Deseja mesmo excluir?")) {
            //direcionar para exclusão
            location.href = "excluir/atividade/" + id;
        }
    }

    $(document).ready(function() {
        $("#tabAtividade").DataTable({
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