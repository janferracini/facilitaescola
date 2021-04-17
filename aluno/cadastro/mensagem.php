<?php
//verificar se não está logado
// if (!isset($_SESSION["hqs"]["id"])) {
//     exit;
// }

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
                <input type="text" name="titulo" id="titulo" class="form-control" required data-parsley-required-message="Preencha o título" placeholder="Digite o Título da mensagem">
                <label for="mensagem">Mensagem:</label>
                <textarea type="text" name="mensagem" id="mensagem" class="form-control" required data-parsley-required-message="Preencha a mensagem" placeholder="Digite a Mensagem"> </textarea>
            </div>



        </div>

        <button type="submit" class="btn btn-success margin">
            <i class="fas fa-check"></i> Gravar Dados
        </button>
    </form>

</div>