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
                <h1 class="m-0 text-dark">Enviar Mensagem </h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->



<div class="container">

    <div class="float-right">
        <a href="listar/mensagem" class="btn btn-outline-info">Listar Enviadas </a>
    </div>

    <div class="clearfix"></div> <!-- Ignora os floats -->

    <form action="salvar/mensagem" name="formCadastro" method="post" data-parsley-validate enctype="multipart/form-data" role="form">
        <div class="row mb-3">
            <div class="col-sm-12">
                <label for="mensagem">Título:</label>
                <input type="text" name="titulo" id="titulo" maxlength="60" minlength="12" class="form-control" required data-parsley-required-message="Preencha o título" placeholder="Digite o Título da mensagem">
                <label for="mensagem">Mensagem:</label>
                <textarea type="text" name="mensagem" maxlength="1024" id="mensagem" class="form-control" required data-parsley-required-message="Preencha a mensagem" placeholder="Digite a Mensagem"></textarea>
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