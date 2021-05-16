<?php
// verificar se está logado
if (!isset($_SESSION['facilita_escola']['id'])) {
    exit;
}

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Relatórios</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="container">

    <div class="card-body table-responsive p-0 mt-3">
        <table id="tabTurma" class="table table-hover text-nowrap">
            <tbody>
                <tr>
                    <td>Alunos por Turma </td>
                    <td style="width: 20%;">
                        <a href="" data-toggle='modal' data-titulo='Alunos por Turma' id='aluno-professor' class="btn btn-outline-laranja btn-sm aluno-turma">Selecionar</a>
                    </td>
                </tr>
                <tr>
                    <td>Alunos por Professor </td>
                    <td style="width: 20%;">
                        <a href="relatorios/teste1.php" target="_blank" class="btn btn-outline-laranja btn-sm">Selecionar</a>
                    </td>
                </tr>
                <tr>
                    <td>Atividades por Turma </td>
                    <td style="width: 20%;">
                        <a href="" class="btn btn-outline-laranja btn-sm ">Selecionar</a>
                    </td>
                </tr>
                <tr>
                    <td>Recados por Turma </td>
                    <td style="width: 20%;">
                        <a href="" class="btn btn-outline-laranja btn-sm ">Selecionar</a>
                    </td>
                </tr>
                <tr>
                    <td>Recados por mês </td>
                    <td style="width: 200px;">
                        <a href="" class="btn btn-outline-laranja btn-sm ">Selecionar</a>
                    </td>
                </tr>
                <tr>
                    <td>Mensagens recebidas por mês</td>
                    <td style="width: 200px;">
                        <a href="" class="btn btn-outline-laranja btn-sm ">Selecionar</a>
                    </td>
                </tr>
                <tr>
                    <td>Aniversariantes do mês </td>
                    <td style="width: 20%;">
                        <a href="" class="btn btn-outline-laranja btn-sm ">Selecionar</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->

    <!-- Modal Aluno-Turma -->
    <div id="aluno-turma" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="titulo"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body">
                    <form action="relatorios/teste1">
                        <label for="turma">Turma</label>
                        <input id="turma_id" name="turma_id" class="form-control" list="listaTurma" data-parsley-required-message="Selecione a turma">
                        <datalist id="listaTurma">
                            <?php
                            $sql = "SELECT t.*,t.id tid, p.*
                                        FROM turma t
                                        INNER JOIN periodo p ON (p.id = t.periodo_id)
                                        ORDER BY serie";
                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();

                            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                                // separar os dados
                                $serie     = $dados->serie;
                                $descricao = $dados->descricao;
                                $ano       = $dados->ano;
                                $periodo   = $dados->periodo;
                                $turma_id  = $dados->tid;
                                echo '<option value=" ' . $turma_id . ' - ' . $serie . ' ' . $descricao . ' / ' . $periodo . ' (' . $ano . ')">';
                            };
                            ?>
                        </datalist>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnok" class="btn btn-success">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal Aluno-Turma -->

    <script>
        $(document).on('click', '#btnok', function() {
            alert('TESTE') //passar a turma para o arquivo relatorios/aluno-turma
        });



        // aluno-turma
        $('.aluno-turma').on('click', function() {
            var titulo = $(this).data('titulo'); // vamos buscar o valor do atributo data-name que temos no botão que foi clicado
            var id = $(this).data('id'); // vamos buscar o valor do atributo data-id
            $('span.titulo').text(titulo); // inserir na o nome na pergunta de confirmação dentro da modal
            $('#aluno-turma').modal('show'); // modal aparece
        });
    </script>

</div>