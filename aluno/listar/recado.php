<?php
//verificar se está logado
if (!isset($_SESSION['facilita_escola']['id'])) {
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
    <div class="card-body p-0 mt-3">
        <table id="tabRecado" class="table table-hover text-nowrap table-responsive-xxl">
            <thead>
                <tr>
                    <th style="width: 20%;">Data de Postagem</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th style="width: 20%;"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $idaluno = $_SESSION["facilita_escola"]["id"];
                $sql = "SELECT  r.id rid, r.*, date_format(r.data_postagem, '%d/%m/%Y') dp,
                                t.id tid, t.*, tm.*, m.*, p.id pid
                        FROM recado r
                        INNER JOIN turma t ON (t.id = r.turma_id)
                        INNER JOIN turma_matricula tm ON (tm.id = t.id)
                        INNER JOIN matricula m ON (m.id = tm.matricula_id)
                        INNER JOIN pessoa p ON (p.id = m.pessoa_id)
                        WHERE p.id = $idaluno
                        ORDER BY r.id DESC";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    // Separar os dados
                    $id       = $dados->rid;
                    $titulo   = $dados->titulo;
                    $conteudo = $dados->conteudo;
                    $data_postagem = $dados->dp;


                    // Mostrar na tela
                    echo "
                        <tr>
                            <td>" . $data_postagem . "</td>
                            <td>" . $titulo . "</td>
                            <td>" . substr($conteudo, 0, 35) . "(...)</td> 
                            <td> 
                                <a class='visualizar btn btn-outline-laranja margin' data-conteudo='$conteudo' 
                                data-postagem='$data_postagem' data-titulo='$titulo' data-id='$id' data-toggle='modal' 
                                data-target='#mensagemModal' id='visualizar'>
                                    Visualizar 
                                </a>
                            </td>
                        </tr>";
                }
                ?>

                <div id="myModal" class="modal fade" role="dialog">
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
                                <button type="button" class="btn btn-outline-laranja
                                " data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>


            </tbody>
        </table>
    </div>

    <script>
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
    </script>
    <!-- /.card-body -->
</div>