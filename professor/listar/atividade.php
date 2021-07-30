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

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Atividades Cadastradas</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">

    <div class="float-right">
        <a href="cadastro/atividade" class="btn btn-outline-laranja">Nova Atividade</a>
    </div>

    <div class="clearfix"></div>

    <div class="card-body table-responsive p-0 mt-3 pb-3">
        <table id="tabAtividade" class="table ui celled table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 20%;">Data de Postagem</th>
                    <th>Atividade</th>
                    <th>Turma</th>
                    <th style="width: 20%;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $idprofessor = $_SESSION["facilita_escola"]["id"];
                $sql = "SELECT a.id aid, a.*, date_format(a.data_postagem, '%d/%m/%Y') data_postagem,
                                g.*, t.*, p.*, d.*, pr.*, pe.id
                        FROM atividade a
                        INNER JOIN grade g ON (g.id = a.grade_id) 
                        INNER JOIN disciplina d ON (d.id = g.disciplina_id)
                        INNER JOIN turma t ON (t.id = g.turma_id) 
                        INNER JOIN periodo p ON (p.id = t.periodo_id)
                        INNER JOIN professor pr ON (pr.id = g.professor_id)
                        INNER JOIN pessoa pe ON (pe.id = pr.pessoa_id)
                        WHERE pr.pessoa_id = $idprofessor
                        ORDER BY a.id DESC";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $id         = $dados->aid;
                    $atividade  = $dados->atividade;
                    $arquivo    = $dados->arquivo;
                    $data       = $dados->data_postagem;
                    $disciplina = $dados->disciplina;
                    $serie      = $dados->serie;
                    $descricao  = $dados->descricao;
                    $periodo    = $dados->periodo;

                    echo '<tr>
                <td>' . $data . '</td>
                <td>' . substr($atividade, 0, 50) . '</td>
                <td>' . $disciplina . ' - ' . $serie . ' ' . $descricao . ' / ' . $periodo . ' </td>
                
                <td>
                <a href="../atividades/' . $arquivo . '" download="Atividade ' . $disciplina . '-' . $serie . '' . $descricao . '(' . $periodo . ')" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-down"></i>
                    </a>

                <a href="cadastro/atividade/' . $id . '" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="excluir(' . $id . ')">
                    <i class="fas fa-trash"></i></button>
                </td>
                </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function excluir(id) {
        if (confirm("Deseja mesmo excluir?")) {
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