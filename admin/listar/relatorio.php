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

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Relatórios</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">

    <div class="card-body table-responsive p-0 mt-3">
        <table id="tabTurma" class="table table-hover text-nowrap">
            <tbody>
                <tr>
                    <td>Alunos por Turma </td>
                    <td style="width: 20%;">
                        <a href="" data-toggle='modal' data-titulo='Alunos por Turma' class="btn btn-outline-laranja btn-sm aluno-turma">Selecionar</a>
                    </td>
                </tr>
                <tr>
                    <td>Alunos por Professor </td>
                    <td style="width: 20%;">
                        <a href="" data-toggle='modal' data-titulo='Alunos por Professor' class="btn btn-outline-laranja btn-sm aluno-professor">Selecionar</a>
                    </td>
                </tr>
                <tr>
                    <td>Atividades por Turma </td>
                    <td style="width: 20%;">
                        <a href="" data-toggle='modal' data-titulo='Atividades por Turma' class="btn btn-outline-laranja btn-sm atividade-turma">Selecionar</a>
                    </td>
                </tr>
                <tr>
                    <td>Recados por Turma </td>
                    <td style="width: 20%;">
                        <a href="" data-toggle='modal' data-titulo='Recados por Turma' class="btn btn-outline-laranja btn-sm recado-turma">Selecionar</a>
                    </td>
                </tr>
                <tr>
                    <td>Recados por período </td>
                    <td style="width: 200px;">
                        <a href="" data-toggle='modal' data-titulo='Recados por Mês' class="btn btn-outline-laranja btn-sm recado-periodo">Selecionar</a>
                    </td>
                </tr>
                <tr>
                    <td>Mensagens recebidas por período</td>
                    <td style="width: 200px;">
                        <a href="" data-toggle='modal' data-titulo='Mensagens por Mês' class="btn btn-outline-laranja btn-sm mensagem_periodo">Selecionar</a>
                    </td>
                </tr>
                <tr>
                    <td>Aniversariantes do mês </td>
                    <td style="width: 20%;">
                        <a href="" data-toggle='modal' data-titulo='Aniversariantes do Mês' class="btn btn-outline-laranja btn-sm aniversario-mes">Selecionar</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="aluno-turma" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="titulo"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="relatorios/aluno_turma" method="POST">
                        <label for="turma">Turma</label>
                        <input id="turma_id" autocomplete="off" name="turma_id" class="form-control" list="listaTurma" required data-parsley-required-message="Selecione a turma">
                        <datalist id="listaTurma">
                            <?php
                            $sql = "SELECT t.*,t.id tid, p.*
                                    FROM turma t
                                    INNER JOIN periodo p ON (p.id = t.periodo_id)
                                    ORDER BY serie";

                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();
                            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                                $serie     = $dados->serie;
                                $descricao = $dados->descricao;
                                $ano       = $dados->ano;
                                $periodo   = $dados->periodo;
                                $turma_id  = $dados->tid;
                                echo '<option value=" ' . $turma_id . ' - ' . $serie . ' ' . $descricao . ' / ' . $periodo . ' (' . $ano . ')">';
                            };
                            ?>
                        </datalist>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-laranja">Gerar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="aluno-professor" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="titulo"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="relatorios/aluno_professor" method="POST">
                        <label for="professor">Professor</label>
                        <input id="professor_id" autocomplete="off" name="professor_id" class="form-control" list="listaProfessor" required data-parsley-required-message="Selecione o professor">
                        <datalist id="listaProfessor">
                            <?php
                            $sql = "SELECT p.id pid, p.*, pe.id, pe.nome
                                    FROM professor p
                                    INNER JOIN pessoa pe ON (pe.id = p.pessoa_id)
                                    ORDER BY nome";
                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();

                            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                                $nome     = $dados->nome;
                                $professor_id  = $dados->pid;
                                echo '<option value=" ' . $professor_id . ' - ' . $nome . '">';
                            };
                            ?>
                        </datalist>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-laranja">Gerar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="atividade-turma" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="titulo"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="relatorios/atividade_turma" method="POST">
                        <label for="turma">Turma</label>
                        <input id="turma_id" autocomplete="off" name="turma_id" class="form-control" list="listaTurma" required data-parsley-required-message="Selecione a turma">
                        <datalist id="listaTurma">
                            <?php
                            $sql = "SELECT t.*,t.id tid, p.*
                                    FROM turma t
                                    INNER JOIN periodo p ON (p.id = t.periodo_id)
                                    ORDER BY serie";
                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();

                            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                                $serie     = $dados->serie;
                                $descricao = $dados->descricao;
                                $ano       = $dados->ano;
                                $periodo   = $dados->periodo;
                                $turma_id  = $dados->tid;
                                echo '<option value=" ' . $turma_id . ' - ' . $serie . ' ' . $descricao . ' / ' . $periodo . ' (' . $ano . ')">';
                            };
                            ?>
                        </datalist>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-laranja">Gerar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="recado-turma" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="titulo"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="relatorios/recado_turma" method="POST">
                        <label for="turma">Turma</label>
                        <input id="turma_id" autocomplete="off" name="turma_id" class="form-control" list="listaTurma" required data-parsley-required-message="Selecione a turma">
                        <datalist id="listaTurma">
                            <?php
                            $sql = "SELECT t.*,t.id tid, p.*
                                        FROM turma t
                                        INNER JOIN periodo p ON (p.id = t.periodo_id)
                                        ORDER BY serie";
                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();

                            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                                $serie     = $dados->serie;
                                $descricao = $dados->descricao;
                                $ano       = $dados->ano;
                                $periodo   = $dados->periodo;
                                $turma_id  = $dados->tid;
                                echo '<option value=" ' . $turma_id . ' - ' . $serie . ' ' . $descricao . ' / ' . $periodo . ' (' . $ano . ')">';
                            };
                            ?>
                        </datalist>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-laranja">Gerar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="recado-periodo" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="titulo"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="relatorios/recado_periodo" method="POST">
                        <label for="mes">Mês</label>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="mes">
                            <option hidden disabled selected value>Selecione o mês</option>
                            <option value="1">Janeiro</option>
                            <option value="2">Fevereiro</option>
                            <option value="3">Março</option>
                            <option value="4">Abril</option>
                            <option value="5">Maio</option>
                            <option value="6">Junho</option>
                            <option value="7">Julho</option>
                            <option value="8">Agosto</option>
                            <option value="9">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                        </select>
                        <label for="ano">Ano</label>
                        <input type="nuber" required name="ano" class="form-control sm">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-laranja">Gerar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="mensagem_periodo" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="titulo"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="relatorios/mensagem_periodo" method="POST">
                        <label for="mes">Mês</label>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="mes">
                            <option hidden disabled selected value>Selecione o mês</option>
                            <option value="1">Janeiro</option>
                            <option value="2">Fevereiro</option>
                            <option value="3">Março</option>
                            <option value="4">Abril</option>
                            <option value="5">Maio</option>
                            <option value="6">Junho</option>
                            <option value="7">Julho</option>
                            <option value="8">Agosto</option>
                            <option value="9">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                        </select>
                        <label for="ano">Ano</label>
                        <input type="nuber" required name="ano" class="form-control sm">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-laranja">Gerar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="aniversario-mes" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="titulo"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="relatorios/aniversario_mes" method="POST">
                        <label for="mes">Mês</label>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="mes">
                            <option hidden disabled selected value>Selecione o mês</option>
                            <option value="1">Janeiro</option>
                            <option value="2">Fevereiro</option>
                            <option value="3">Março</option>
                            <option value="4">Abril</option>
                            <option value="5">Maio</option>
                            <option value="6">Junho</option>
                            <option value="7">Julho</option>
                            <option value="8">Agosto</option>
                            <option value="9">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                        </select>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-laranja">Gerar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.aluno-turma').on('click', function() {
            var titulo = $(this).data('titulo');
            var id = $(this).data('id');
            $('span.titulo').text(titulo);
            $('#aluno-turma').modal('show');
        });

        $('.aluno-professor').on('click', function() {
            var titulo = $(this).data('titulo');
            var id = $(this).data('id');
            $('span.titulo').text(titulo);
            $('#aluno-professor').modal('show');
        });

        $('.atividade-turma').on('click', function() {
            var titulo = $(this).data('titulo');
            var id = $(this).data('id');
            $('span.titulo').text(titulo);
            $('#atividade-turma').modal('show');
        });

        $('.recado-turma').on('click', function() {
            var titulo = $(this).data('titulo');
            var id = $(this).data('id');
            $('span.titulo').text(titulo);
            $('#recado-turma').modal('show');
        });

        $('.recado-periodo').on('click', function() {
            var titulo = $(this).data('titulo');
            var id = $(this).data('id');
            $('span.titulo').text(titulo);
            $('#recado-periodo').modal('show');
        });

        $('.mensagem_periodo').on('click', function() {
            var titulo = $(this).data('titulo');
            var id = $(this).data('id');
            $('span.titulo').text(titulo);
            $('#mensagem_periodo').modal('show');
        });

        $('.aniversario-mes').on('click', function() {
            var titulo = $(this).data('titulo');
            var id = $(this).data('id');
            $('span.titulo').text(titulo);
            $('#aniversario-mes').modal('show');
        });
    </script>
</div>