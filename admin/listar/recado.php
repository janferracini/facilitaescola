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

                <!-- <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><span class="titulo"></h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body">
                                <p>
                                    <strong>Título: </strong><span class="titulo"></span> <br>
                                    <strong>Data: </strong><span class="postagem"></span> <br>
                                    <strong>Descrição: </strong><span class="conteudo"></span> <br>

                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div> -->


            </tbody>
        </table>
    </div>

    <!-- <script>
        $('.visualizar').on('click', function() {
            var nome = $(this).data('nome'); // vamos buscar o valor do atributo data-name que temos no botão que foi clicado
            var conteudo = $(this).data('conteudo');
            var titulo = $(this).data('titulo');
            var postagem = $(this).data('postagem')
            var id = $(this).data('id'); // vamos buscar o valor do atributo data-id
            $('span.nome').text(nome); // inserir na o nome na pergunta de confirmação dentro da modal
            $('span.titulo').text(titulo);
            $('span.conteudo').text(conteudo);
            $('span.postagem').text(postagem);
            $('#myModal').modal('show'); // modal aparece
        });
    </script> -->
    <!-- /.card-body -->
</div>