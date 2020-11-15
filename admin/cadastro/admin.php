<?php

if (!isset($id)) $id = "";

// tabela pessoa
$nome = $rg = $cpf = $data_nascimento = $senha = $email = $login =
    // tabela aluno
    $matricula = $foto = $serie = $pessoa_id =
    // tabela endereço
    $logradouro = $numero = $cep = $complemento = $cidade_id = '';

if (!empty($id)) {
    $sql = "SELECT a.matricula, a.foto, a.serie, a.pessoa_id,
            pe.nome, pe.rg. pe.cpf, pe.data_nascimento, pe.senha, pe.senha, pe.email, pe.login,
            e.logradouro, e.numero, e.cep, e.complemento, e.cidade_id
            FROM pessoa p
            INNER JOIN cidade c ON (e.id = cidade_id)
            WHERE pe.id = :id
            LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    // caso não existir aluno cadastrado
    if (empty($dados->id)) {
        echo "<p class='alert alert-danger'> Aluno não cadastrado </p>";
    }

    $id         = $dados->id;
    $nome       = $dados->nome;
    $rg         = $dados->rg;
    $cpf        = $dados->cpf;
    $data_nascimento = $dados->data_nascimento;
    $senha      = $dados->senha;
    $email      = $dados->email;
    $login      = $dados->login;
    $matricula  = $dados->matricula;
    $foto       = $dados->foto;
    $serie      = $dados->serie;
    $pessoa_id  = $dados->pessoa_id;
    $logradouro = $dados->logradouro;
    $numero     = $dados->numero;
    $cep        = $dados->cep;
    $complemento = $dados->complemento;
    $cidade_id  = $dados->cidade_id;
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Cadastro de Equipe Administrativa</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container">

    <div class="float-right">
        <a href="cadastro/aluno" class="btn btn-success">Novo Registro</a>
        <a href="listar/aluno" class="btn btn-info">Listar Registro</a>
    </div>

    <div class="clearfix"></div> <!-- Ignora os floats -->

    <form action="salvar/aluno" name="formCadastroAluno" method="post" data-parsley-validate enctype="multipart/form-data" role="form">
        <div class="row mb-3">

            <input type="hidden" class="form-control" name="id" id="id" readonly value="<?= $id ?>">

            <!-- LINHA 1 -->
            <div class="col-12 col-md-12">
                <label for="nome"> Nome Completo </label>
                <input type="text" class="form-control" id="nome" name="nome" required data-parsley-required-message="Preencha o nome" value="<?= $nome ?>">
            </div>

            <!-- LINHA 2 -->
            <div class="col-12 col-md-4">
                <label for="login"> Login </label>
                <input type="text" class="form-control" id="login" name="login" required data-parsley-required-message="Preencha o nome do login" placeholder="Insira com o login de acesso" value="<?= $login ?>">
            </div>

            <div class="col-12 col-md-8">
                <label for="email"> E-mail </label>
                <input type="number" class="form-control" id="email" name="email" required data-parsley-required-message="Preencha com um e-mail válido" placeholder="Digite um e-mail válido" value="<?= $email ?>">
            </div>

            <!-- LINHA 3-->
            <div class="col-12 col-md-4">
                <label for="rg"> RG </label>
                <input type="text" class="form-control" id="rg" name="rg" required data-parsley-required-message="Preencha o RG" value="<?= $rg ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="CPF"> CPF </label>
                <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $cpf ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="dataNascimento"> Data De Nascimento </label>
                <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" required data-parsley-required-message="Preencha a data de nascimento" value="<?= $data_nascimento ?>">
            </div>

            <!-- LINHA 4 -->
            <div class="col-12 col-md-4">
                <label for="cep"> CEP </label>
                <input type="text" class="form-control" id="cep" name="cep" required data-parsley-required-message="Preencha com um CEP válido" value="<?= $cep ?>">
            </div>

            <div class="col-12 col-md-8">
                <label for="cidade"> Cidade </label>
                <input type="text" class="form-control" id="cidade" name="cidade" required data-parsley-required-message="Preencha a cidade" value="<?= $cidade_id ?>">
            </div>

            <!-- LINHA 5 -->
            <div class="col-12 col-md-8">
                <label for="endereco"> Endereço Completo</label>
                <input type="text" class="form-control" id="endereco" name="endereco" required data-parsley-required-message="Preencha o endereço" value="<?= $logradouro ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="numero"> Número </label>
                <input type="text" class="form-control" id="numero" name="numero" required data-parsley-required-message="Preencha com o número da residência" placeholder="Insira o número da residência">
            </div>

            <!-- LINHA 6 -->
            <div class="col-12 col-md-12">
                <label for="complemento"> Complemento </label>
                <input type="text" class="form-control" id="complement" name="completo">
            </div>

            <!-- LINHA 7 -->
            <div class="col-12 col-md-4">
                <label for="telefone1"> Telefone Obrigatório</label>
                <input type="text" class="form-control" id="telefone" name="telefone" required data-parsley-required-message="Preencha com o número de telefone">
            </div>

            <div class="col-12 col-md-4">
                <label for="telefone2"> Telefone Opcional </label>
                <input type="text" class="form-control" id="telefone2" name="telefone2">
            </div>

            <div class="col-12 col-md-4">
                <label for="foto"> Foto </label>
                <input type="file" class="form-control" id="foto" name="foto" accept=".jpeg, .jpg">
            </div>

            <!-- LINHA 7 -->


            <div class="col-12 col-md-4">
                <label for="senha"> Senha </label>
                <input type="password" class="form-control" id="senha" name="senha" require data-parsley-required-message="Insira uma senha" placeholder="Insira com a senha inicial de acesso">
            </div>

            <div class="col-12 col-md-4">
                <label for="confirmaSenha">Confirmar Senha </label>
                <input type="password" class="form-control" id="confirmaSenha" name="confirmaSenha" require data-parsley-required-message="Insira a senha novamente" placeholder="Insira com a senha inicial de acesso">
            </div>
        </div>


        <a class="btn btn-success margin" data-toggle="modal" data-target="#gerenciarModal" style="color : #fff;">
            <i class="fas fa-cog"></i> Gerenciar
        </a>

        <button type="submit" class="btn btn-success margin">
            <i class="fas fa-check"></i> Gravar Dados
        </button>
    </form>

    <!-- Logout Modal-->
    <div class="modal fade" id="gerenciarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Gerenciar Equipe Administrativa</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Status do Usuário</div>

                <div class="col-12 col-md-6">
                    <form>
                        <select id="status" class="form-control">
                            <option selected>Ativo </option>
                            <option>Inativo </option>
                        </select>
                    </form>
                </div>

                <div class="modal-footer mt-2">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                    <a class="btn btn-primary" href="#">Salvar</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#data_nascimento").inputmask("99/99/9999");
            $("#cpf").inputmask("999.999.999-99");
            $("#telefone1").inputmask("(99) 9999-9999");
            $("#telefone2").inputmask("(99) 99999-9999");
            $("#cep").inputmask("99.999-999");
        });
    </script>
</div>