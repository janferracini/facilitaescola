<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
} ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div>
                <h1 class="m-0 text-dark">Facilita Escola</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- row -->
<div class="row pt-2">
    <div class="col-12 col-sm- col-md-4">
        <a href="listar/aluno" style="text-decoration: none;">
            <div class="info-box" href="listar/aluno" class="nav-link">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-graduate"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><strong>Alunos</strong></span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <a href="listar/professor" style="text-decoration: none;">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-apple-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><strong>Professores</strong></span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <a href="listar/admin" style="text-decoration: none;">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-laptop-code"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><strong>Equipe Administrativa</strong></span>
                </div>
            </div>
        </a>
    </div>

</div>
<!--/.row -->

<!-- Primeira linha de cards -->
<div class="row">
    <!-- div mensagens -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Últimas Mensagens</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover m-0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Turma</th>
                                <th>Mensagem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT  me.*, date_format(me.data_postagem, '%d/%m/%Y') dp, 
                                            ma.id, ma.pessoa_id, p.id, p.nome, t.*, tm.*
                                    FROM mensagem me
                                    INNER JOIN matricula ma ON (ma.id = me.matricula_id)
                                    INNER JOIN turma_matricula tm ON (tm.matricula_id = ma.id)
                                    INNER JOIN turma t ON (t.id = tm.turma_id)
                                    INNER JOIN pessoa p ON (p.id = ma.pessoa_id)
                                    ORDER BY me.data_postagem DESC
                                    LIMIT 6";

                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();

                            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                                // Separar os dados
                                $idmensagem = $dados->id;
                                $data_postagem = $dados->dp;
                                $aluno = $dados->nome;
                                $titulo = $dados->titulo;
                                $mensagem = $dados->mensagem;
                                $serie = $dados->serie;
                                $descricao = $dados->descricao;

                                // Mostrar na tela
                                echo "
                                    <tr>
                                        <td>" . $aluno . "</td>
                                        <td>" . $serie . " - " . $descricao . "</td>
                                        <td> " . substr($mensagem, 0, 35) . "(...)</td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <a href="listar/mensagem" class="btn btn-sm btn-outline-laranja float-right">Ver todas</a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
    <!-- fim div mensagens -->

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Recados</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover m-0">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Data</th>
                                <th style="width: 30%;">Turma</th>
                                <th>Conteúdo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT *,  date_format(data_postagem, '%d/%m/%Y') data_postagem
                            FROM recado
                            ORDER BY id DESC
                                    LIMIT 6";

                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();

                            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                                // Separar os dados
                                $id       = $dados->id;
                                $titulo   = $dados->titulo;
                                $conteudo = $dados->conteudo;
                                $data      = $dados->data_postagem;



                                // Mostrar na tela
                                echo "
                                    <tr>
                                        <td>" . $data . "</td>
                                        <td>" . $titulo . "</td>
                                        <td> " . substr($conteudo, 0, 35) . "(...)</td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <a href="listar/recado" class="btn btn-sm btn-outline-laranja float-right">Ver todos</a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
    <!-- fim div eventos -->
</div>
<!-- fim primeira linha de cars -->