<?php
//verificar se está logado
// if (!isset($_SESSION['hqs']['id'])) {
//     exit;
// }
// 
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

    <div class="float-right">
        <a href="cadastro/recado" class="btn btn-outline-laranja">Novo Recado</a>
    </div>

    <div class="card-body p-0 mt-3">
        <table id="tabRecado" class="table table-hover text-nowrap table-responsive-xxl">
            <thead>
                <tr>
                    <th>Data de Postagem</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT  r.id rid, r.*, date_format(r.data_postagem, '%d/%m/%Y') dp,
                                g.id gid,
                                t.id tid, t.*
                        FROM recado r
                        INNER JOIN grade g ON (g.id = r.grade_id)
                        INNER JOIN turma t ON (t.id = g.turma_id)
                        ORDER BY r.data_postagem DESC";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    // Separar os dados
                    $id       = $dados->rid;
                    $titulo   = $dados->titulo;
                    $conteudo = $dados->conteudo;
                    $data_postagem      = $dados->data_postagem;


                    // Mostrar na tela
                    echo '<tr>
                        <td>' . $data_postagem . '</td>
                        <td>' . $titulo . '</td>
                        <td>' . substr($conteudo, 0, 35) . '(...)</td>
                        <td><a href="cadastro/recado/' . $id . '" class="btn btn-success btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <button type="button" class="btn btn-danger btn-sm" onclick="excluir(' . $id . ')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>