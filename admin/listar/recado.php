<?php
//verificar se está logado
// if (!isset($_SESSION['hqs']['id'])) {
//     exit;
// }
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
                                t.*, p.*, d.*, g.*
                        FROM recado r
                        INNER JOIN turma t ON (t.id = r.turma_id) 
                        INNER JOIN grade g ON (g.turma_id = t.id) 
                        INNER JOIN disciplina d ON (d.id = g.disciplina_id)
                        INNER JOIN periodo p ON (p.id = t.periodo_id)
                        GROUP BY r.id DESC";


                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    //recado
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
                
                            <td><a href="cadastro/recado/' . $id . '" class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="button" class="btn btn-danger btn-sm" onclick="excluir(' . $id . ')">
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
</script>