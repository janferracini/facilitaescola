<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 2) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Mensagens Encaminhadas</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">
    <div class="card-body p-0 mt-3 pb-3">
        <table id="tabMensagem" class="table ui celled table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Data de Envio</th>
                    <th>Título</th>
                    <th>Mensagem</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $idaluno = $_SESSION["facilita_escola"]["id"];
                $sql = "SELECT  me.id idmensagem, me.*, date_format(me.data_postagem, '%d/%m/%Y') dp, 
                ma.id maid, ma.pessoa_id, p.id pid, p.nome
                    FROM mensagem me
                    INNER JOIN matricula ma ON (ma.id = me.matricula_id)
                    INNER JOIN pessoa p ON (p.id = ma.pessoa_id)
                    WHERE ma.pessoa_id = $idaluno
                    ORDER BY me.data_postagem DESC";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    // Separar os dados
                    $idmensagem = $dados->idmensagem;
                    $data_postagem = $dados->dp;
                    $aluno = $dados->nome;
                    $titulo = $dados->titulo;
                    $mensagem = $dados->mensagem;

                    // Mostrar na tela
                    echo "
                        <tr>
                            <td>" . $data_postagem . "</td>
                            <td>" . $titulo . "</td>
                            <td>" . substr($mensagem, 0, 35) . "(...)</td>
                            <td> 
                                <a href='$idmensagem' class='visualizar btn btn-outline-laranja margin' data-mensagem='$mensagem' data-postagem='$data_postagem' data-titulo='$titulo'data-nome='$aluno' data-id='$idmensagem' data-toggle='modal' data-target='#mensagemModal' style='color : #ed8032;' id='visualizar'>
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
                                <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
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

        $(document).ready(function() {
            $("#tabMensagem").DataTable({
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
    <!-- /.card-body -->
</div>