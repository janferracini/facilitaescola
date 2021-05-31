<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Recados Enviados</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="float-right">
        <a href="cadastro/recado" class="btn btn-outline-laranja">Novo Recado</a>
    </div>
    <div class="clearfix"></div>
    <div class="card-body p-0 mt-3">
        <table id="tabRecado" class="table table-hover text-nowrap table-responsive-xxl">
            <thead>
                <tr>
                    <th style="width: 20%;">Data Postagem</th>
                    <th>Recados</th>
                    <th>Turma</th>
                    <th style="width: 20%;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT r.id rid, r.*, date_format(r.data_postagem, '%d/%m/%Y') data_postagem,
                                g.*, t.*, p.*, d.*
                        FROM recado r
                        INNER JOIN grade g ON (g.id = r.grade_id) 
                        INNER JOIN disciplina d ON (d.id = g.disciplina_id)
                        INNER JOIN turma t ON (t.id = g.turma_id) 
                        INNER JOIN periodo p ON (p.id = t.periodo_id)
                        ORDER BY r.id DESC";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    //recado
                    $id     = $dados->rid;
                    $titulo = $dados->titulo;
                    $data_postagem = $dados->data_postagem;
                    //turma
                    $serie      = $dados->serie;
                    $descricao  = $dados->descricao;
                    //periodo
                    $periodo    = $dados->periodo;

                    echo '<tr>
                            <td>' . $data_postagem . '</td>
                            <td>' . $titulo . '</td>
                            <td>' . $serie . ' ' . $descricao . ' / ' . $periodo . ' </td>
                
                            <td><a href="cadastro/recado/' . $id . '" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="excluir(' . $id . ')">
                                <i class="fas fa-trash"></i>
                            </td>
                        </button>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<script>
    //função para perguntar se deseja excluir. Se sim, direcionar para o endereço de exclusão
    function excluir(id) {
        //perguntar
        if (confirm("Deseja mesmo excluir?")) {
            //direcionar para exclusão
            location.href = "excluir/recado/" + id;
        }
    }

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
                    "next": ">",
                    "previous": "<"
                }
            }
        });
    })
</script>