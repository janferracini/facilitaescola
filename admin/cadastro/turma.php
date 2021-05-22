<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}

if (!isset($id)) $id = "";
$serie = $descricao = $periodo = $ano = $periodo_id = '';

if (!empty($id)) {
    //select nos dados da turma
    $sql = "SELECT  t.id,
                    t.serie,
                    t.descricao,
                    t.ano,
                    t.periodo_id,
                    p.id idperiodo,
                    p.periodo
            FROM turma t
            INNER JOIN periodo p on (p.id = t.periodo_id)
            WHERE t.id = :id
            LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id)) {
        echo "<p class='alert alert-danger'>Turma não existe</p>";
    }

    $id             = $dados->id;
    $serie          = $dados->serie;
    $descricao      = $dados->descricao;
    $periodo        = $dados->periodo;
    $ano            = $dados->ano;
    $periodo_id     = $dados->periodo_id;
    $idperiodo      = $dados->idperiodo;
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Cadastro de Turma</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container">

    <div class="float-right">
        <a href="listar/turma" class="btn btn-outline-info">Listar Turmas</a>
    </div>

    <div class="clearfix"></div> <!-- Ignora os floats -->

    <form action="salvar/turma" name="formCadastro" method="post" data-parsley-validate enctype="multipart/form-data" role="form">
        <div class="row mb-3">
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="id" id="id" readonly value="<?= $id ?>">
                <label for="serie">Série:</label>
                <input type="text" autocomplete="off" name="serie" id="serie" class="form-control" required data-parsley-required-message="Preencha a Série" value="<?= $serie ?>" placeholder="Digite a Série: Pré, 1, 2, 3 ...">
            </div>

            <div class="col-sm-6">
                <label for="descricao">Descrição:</label>
                <input type="text" autocomplete="off" name="descricao" id="descricao" class="form-control" required data-parsley-required-message="Preencha a Descrição" value="<?= $descricao ?>" placeholder="Digite a Descrição: A, B, C ...">
            </div>

            <div class="col-sm-6">
                <!-- select -->
                <div class="form-group">
                    <label for="periodo">Período</label>
                    <input type="text" autocomplete="off" name="periodo_id" id="periodo_id" class="form-select" list="listaPeriodo" data-parsley-required-message="Selecione o período" value="<?php if (!empty($periodo_id)) echo "$periodo - $periodo_id"; ?>">
                    <datalist id="listaPeriodo">
                        <?php
                        $sql = "SELECT id, periodo
                                    FROM periodo
                                    ORDER BY id";
                        $consulta = $pdo->prepare($sql);
                        $consulta->execute();

                        while ($d = $consulta->fetch(PDO::FETCH_OBJ)) {
                            //separar os dados
                            $periodo_id    = $d->id;
                            $periodo       = $d->periodo;
                            echo '<option value=" ' . $periodo . ' - ' . $periodo_id . '">';
                        };
                        ?>
                    </datalist>
                </div>
            </div>

            <div class="col-sm-6">
                <label for="ano">Ano:</label>
                <input type="text" autocomplete="off" name="ano" id="ano" class="form-control" required data-parsley-required-message="Preencha o Ano" value="<?= $ano ?>" placeholder="Digite o Ano">
            </div>


        </div>

        <div class="float-right">
            <button type="submit" class="btn btn-outline-laranja margin">
                <i class="fas fa-check"></i> Gravar Dados
            </button>
        </div>
        <div class="clearfix"></div> <!-- Ignora os floats -->
    </form>

</div>