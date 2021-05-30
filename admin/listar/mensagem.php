<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Mensagens Recebidas</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">
    <div class="card-body p-0 mt-3">
        <table id="tabDisciplina" class="table table-hover text-nowrap table-responsive-xxl">
            <thead>
                <tr>
                    <th>Data de Envio</th>
                    <th>Aluno</th>
                    <th>Título</th>
                    <th>Mensagem</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT  me.*, date_format(me.data_postagem, '%d/%m/%Y') dp, 
                                ma.id, ma.pessoa_id, p.id, p.nome
                        FROM mensagem me
                        INNER JOIN matricula ma ON (ma.id = me.matricula_id)
                        INNER JOIN pessoa p ON (p.id = ma.pessoa_id)
                        ORDER BY me.data_postagem DESC";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    // Separar os dados
                    $idmensagem = $dados->id;
                    $data_postagem = $dados->dp;
                    $aluno = $dados->nome;
                    $titulo = $dados->titulo;
                    $mensagem = $dados->mensagem;

                    // Mostrar na tela
                    echo "
                        <tr>
                            <td>" . $data_postagem . "</td>
                            <td>" . $aluno . "</td>
                            <td>" . $titulo . "</td>
                            <td>" . substr($mensagem, 0, 35) . "(...)</td>
                            <td> 
                                <a class='btn btn-outline-laranja visualizar' data-mensagem='$mensagem'
                                data-postagem='$data_postagem' data-titulo='$titulo'data-nome='$aluno' 
                                data-id='$idmensagem' data-toggle='modal' data-target='#mensagemModal' 
                                id='visualizar'>
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
                                    <strong>Aluno: </strong><span class="nome"></span> <br>
                                    <strong>Data: </strong><span class="postagem"></span> <br>
                                    <strong>Mensagem: </strong><span class="mensagem"></span> <br>
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-laranja" data-dismiss="modal">OK</button>
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
            var mensagem = $(this).data('mensagem');
            var titulo = $(this).data('titulo');
            var postagem = $(this).data('postagem')
            var id = $(this).data('id'); // vamos buscar o valor do atributo data-id
            $('span.nome').text(nome); // inserir na o nome na pergunta de confirmação dentro da modal
            $('span.titulo').text(titulo);
            $('span.mensagem').text(mensagem);
            $('span.postagem').text(postagem);
            $('#myModal').modal('show'); // modal aparece
        });
    </script>
    <!-- /.card-body -->
</div>