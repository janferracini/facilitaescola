<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 3) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div>
                <h1 class="m-0 text-dark">Facilita Escola</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- row -->
<div class="row">
    <div class="col-12 col-sm- col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-chalkboard"></i></span>

            <div class="info-box-content">
                <a href="listar/grade" style="color: #000; text-decoration: underline;">
                    <span class="info-box-text"><strong>Turmas</strong></span>
                </a>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-pencil-alt"></i></span>

            <div class="info-box-content">
                <a href="listar/atividade" style="color: #000; text-decoration: underline;">
                    <span class="info-box-text"><strong>Atividades</strong></span>
                </a>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-exclamation-triangle"></i></span>

            <div class="info-box-content">
                <a href="listar/recado" style="color: #000; text-decoration: underline;">
                    <span class="info-box-text"><strong>Recados</strong></span>
                </a>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

</div>
<!-- /.row -->

<!-- Primeira linha de cards -->
<div class="row">
    <!-- div mensagens -->
    <div class="col-lg-12">
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
                                <th style="width: 15%;">Data</th>
                                <th style="width: 30%;">Titulo</th>
                                <th>Conteúdo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $idprofessor = $_SESSION["facilita_escola"]["id"];
                            $sql = "SELECT r.id rid, r.*, DATE_FORMAT(r.data_postagem, '%d/%m/%Y') data_postagem,
                                        t.*,g.*, p.*, pe.id
                                    FROM recado r
                                    INNER JOIN grade g ON (g.id = r.grade_id)
                                    INNER JOIN turma t ON (t.id = g.turma_id)
                                    INNER JOIN professor p ON (p.id = g.professor_id)
                                    INNER JOIN pessoa pe ON (pe.id = p.pessoa_id)
                                    WHERE pe.id = $idprofessor
                                    ORDER BY  r.id DESC
                                    LIMIT 6";

                            $consulta = $pdo->prepare($sql);
                            $consulta->execute();

                            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                                // Separar os dados
                                $id       = $dados->rid;
                                $titulo   = $dados->titulo;
                                $conteudo = $dados->conteudo;
                                $data      = $dados->data_postagem;


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
                <a href="listar/recado" class="btn btn-sm btn-outline-laranja float-right">Ver todos</a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
    <!-- fim div recados -->
</div>
<!-- fim primeira linha de cards -->