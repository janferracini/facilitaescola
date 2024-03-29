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
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Recados Cadastrados</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="container">
        <div class="float-right">
            <a href="cadastro/recado" class="btn btn-outline-laranja">Novo Recado</a>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="card-body p-0 mt-3 pb-3">
        <table id="tabRecado" class="table ui celled table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 20%;">Data Postagem</th>
                    <th>Recados</th>
                    <th>Turma</th>
                    <th style="width: 10%;">Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $idprofessor = $_SESSION["facilita_escola"]["id"];
                $sql = "SELECT r.id rid, r.titulo, DATE_FORMAT(r.data_postagem, '%d/%m/%Y') data_postagem,
                t.*, g.*, p.*, pe.id, d.*, pr.*
            FROM recado r
            INNER JOIN grade g ON (g.id = r.grade_id)
            INNER JOIN turma t ON (t.id = g.turma_id)
            INNER JOIN disciplina d ON (d.id = g.disciplina_id)
            INNER JOIN periodo pr ON (pr.id = t.periodo_id)
            INNER JOIN professor p ON (p.id = g.professor_id)
            INNER JOIN pessoa pe ON (pe.id = p.pessoa_id)
            WHERE pe.id = $idprofessor
            ORDER BY r.id DESC";



                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    $id     = $dados->rid;
                    $titulo = $dados->titulo;
                    $data_postagem = $dados->data_postagem;
                    //disciplina
                    $disciplina = $dados->disciplina;
                    //turma
                    $serie      = $dados->serie;
                    $descricao  = $dados->descricao;
                    //periodo
                    $periodo    = $dados->periodo;

                    echo '<tr>
                            <td>' . $data_postagem . '</td>
                            <td>' . $titulo . '</td>
                            <td>' . $disciplina . ' - ' . $serie . ' ' . $descricao . ' / ' . $periodo . ' </td>
                            <td><a href="cadastro/recado/' . $id . '" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </button>
                    </tr>';
                }

                ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $("#tabRecado").DataTable({
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
</div>