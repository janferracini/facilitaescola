<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Facilita Escola</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- row -->
<div class="row">

    <div class="col-lg-4 col-6">
        <a href="listar/atividade" style="text-decoration: none;">
            <!-- small card -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h4>Atividades</h4>
                    <p>Listar atividades</p>
                </div>
                <div class="icon">
                    <i class="fas fa-pencil-alt"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-4 col-6">
        <a href="listar/recado" style="text-decoration: none;">
            <!-- small card -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h4>Recados</h4>
                    <p>Listar recados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-4 col-6">
        <!-- small card -->
        <a href="cadastro/mensagem" style="text-decoration: none;">
            <div class="small-box bg-info">
                <div class="inner">
                    <h4>Mensagem</h4>
                    <p>Enviar Mensagem</p>
                </div>
                <div class="icon">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
        </a>
    </div>

</div>
<!-- /.row -->

<!-- Primeira linha de cards -->
<div class="row">
    <!-- div mensagens -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Últimos Recados</h3>

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
                                <th style="width: 15%;">Data</th>
                                <th style="width: 30%;">Titulo</th>
                                <th>Conteúdo</th>
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
                                    ORDER BY r.id DESC 
                                    LIMIT 6";

                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();

                            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                                // Separar os dados
                                $id       = $dados->rid;
                                $titulo   = $dados->titulo;
                                $conteudo = $dados->conteudo;
                                $data      = $dados->dp;


                                // Mostrar na tela
                                echo "
                                    <tr>
                                        <td>" . $data . "</td>
                                        <td>" . $titulo . "</td>
                                        <td> " . substr($conteudo, 0, 60) . "(...)</td>
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
                <a href="listar/recado" class="btn btn-sm btn-outline-laranja float-right">Ver todas</a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
    <!-- fim div mensagens -->
</div>
<!-- fim primeira linha de cars -->