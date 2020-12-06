<?php

if (!isset($id)) $id = "";

// tabela pessoa
$nome = $login = $senha = $rg = $cpf = $datanascimento = $data_cadastro =
$email = $logradouro = $numero  = $cep = $complemento = $telefone1 = $telefone2 = $foto = $status = $cidade_id = $cidade = $estado = '';

if (!empty($id)) {
    $sql = "SELECT  p.*,
                    c.cidade, c.estado
            FROM pessoa p
            INNER JOIN cidade c ON (c.id = p.id_cidade)
            WHERE p.id = :id
            LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    // caso não existir admin cadastrado
    if (empty($dados->id)) {
        echo "<p class='alert alert-danger'> Administrador não cadastrado </p>";
    }

    $id         = $dados->id;
    $nome       = $dados->nome;
    $rg         = $dados->rg;
    $cpf        = $dados->cpf;
    $datanascimento = $dados->data_nascimento;
    $email       = $dados->email;
    $login       = $dados->login;
    $foto        = $dados->foto;
    $logradouro  = $dados->logradouro;
    $numero      = $dados->numero;
    $cep         = $dados->cep;
    $complemento = $dados->complemento;
    $cidade_id   = $dados->id_cidade;
    $cidade      = $dados->cidade;
    $telefone1  = $dados->telefone1;
    $telefone2  = $dados->telefone2;
    $estado     = $dados->estado;
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
        <a href="cadastro/admin" class="btn btn-success">Novo Registro</a>
        <a href="listar/admin" class="btn btn-info">Listar Registro</a>
    </div>

    <div class="clearfix"></div> <!-- Ignora os floats -->

    <form action="salvar/admin" name="formCadastro" method="post"
    data-parsley-validate enctype="multipart/form-data" role="form">
        <div class="row mb-3">

            <input type="hidden" class="form-control" name="id" id="id" readonly value="<?= $id ?>">

            <!-- LINHA 1 -->
            <div class="col-12 col-md-12">
                <label for="nome"> Nome Completo </label>
                <input type="text" class="form-control" id="nome" name="nome"
                required data-parsley-required-message="Preencha o nome" value="<?= $nome ?>">
            </div>

            <!-- LINHA 2 -->
            <div class="col-12 col-md-4">
                <label for="login"> Login </label>
                <input type="text" class="form-control" id="login" name="login"
                required data-parsley-required-message="Preencha o nome do login"
                placeholder="Insira com o login de acesso" value="<?= $login ?>">
            </div>

            <div class="col-12 col-md-8">
                <label for="email"> E-mail </label>
                <input type="email" class="form-control" id="email" name="email"
                required data-parsley-required-message="Preencha com um e-mail válido"
                placeholder="Digite um e-mail válido" value="<?= $email ?>">
            </div>

            <!-- LINHA 3-->
            <div class="col-12 col-md-4">
                <label for="rg"> RG </label>
                <input type="text" class="form-control" id="rg" name="rg"
                required data-parsley-required-message="Preencha o RG" value="<?= $rg ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="cpf"> CPF </label>
                <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $cpf ?>" onblur="verificarCpf(this.value)">

            </div>

            <div class="col-12 col-md-4">
                <label for="dataNascimento"> Data De Nascimento </label>
                <input type="date" class="form-control" id="dataNascimento" name="dataNascimento"
                required data-parsley-required-message="Preencha a data de nascimento" value="<?= $datanascimento ?>">
            </div>

            <!-- LINHA 4 -->
            <div class="col-12 col-md-4">
                <label for="cep"> CEP </label>
                <input type="text" class="form-control" id="cep" name="cep"
                required data-parsley-required-message="Preencha com um CEP válido" value="<?= $cep ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="cidade"> Cidade</label>
                <input type="text" class="form-control" id="cidade"
                    required data-parsley-required-message="Selecione a cidade" value="<?= $cidade ?>">
            </div>

            <div class="col-12 col-md-1">
                <label for="cidade_id"> ID Cidade</label>
                <input type="text" class="form-control" id="cidade_id" name="cidade_id"
                    required data-parsley-required-message="Selecione a cidade" readonly value="<?= $cidade_id ?>">
            </div>

            <div class="col-12 col-md-3">                
                <label for="cidade"> Estado </label>
                <input type="text" class="form-control" id="estado"
                    required data-parsley-required-message="Selecione o estado" value="<?= $estado ?>">
            </div>

            <!-- LINHA 5 -->
            <div class="col-12 col-md-8">
                <label for="endereco"> Endereço Completo</label>
                <input type="text" class="form-control" id="endereco" name="endereco"
                required data-parsley-required-message="Preencha o endereço" value="<?= $logradouro ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="numero"> Número </label>
                <input type="text" class="form-control" id="numero" name="numero"
                required data-parsley-required-message="Preencha com o número da residência"
                placeholder="Insira o número da residência" value="<?= $numero ?>">
            </div>

            <!-- LINHA 6 -->
            <div class="col-12 col-md-12">
                <label for="complemento"> Complemento </label>
                <input type="text" class="form-control" id="complement" name="completo" value="<?= $complemento ?>">
            </div>

            <!-- LINHA 7 -->
            <div class="col-12 col-md-6">
                <label for="telefone1"> Telefone Obrigatório</label>
                <input type="text" class="form-control" id="telefone1" name="telefone1"
                required data-parsley-required-message="Preencha com o número de telefone" value="<?= $telefone1 ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="telefone2"> Telefone Opcional </label>
                <input type="text" class="form-control" id="telefone2" name="telefone2" value="<?= $telefone2 ?>">
            </div>

            <!-- <div class="col-12 col-md-4 custom-file">
                <label for="foto"> Foto </label>
                <input type="file" class="form-control" id="foto" name="foto" accept=".jpeg, .jpg">
            </div> -->
            <div class="clearfix"></div>

            <!-- LINHA 7 -->
            <div class="col-12 col-md-6">
                <label for="senha"> Senha </label>
                <input type="password" class="form-control" id="senha" name="senha"
                require data-parsley-required-message="Insira uma senha" placeholder="Insira com a senha inicial de acesso">
            </div>

            <div class="col-12 col-md-6">
                <label for="confirmaSenha">Confirmar Senha </label>
                <input type="password" class="form-control" id="confirmaSenha" name="confirmaSenha" 
                require data-parsley-required-message="Insira a senha novamente" placeholder="Insira com a senha inicial de acesso">
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
                <div class="modal-body">

                    <form>
                        <label class="col-12 col-md-6" style="float: left;">Status do Usuário: </label>
                        <select id="status" class="form-control col-12 col-md-6">
                            <option selected>Ativo </option>
                            <option>Inativo </option>
                        </select>

                        <div class="modal-footer mt-2">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
                            <a class="btn btn-primary" href="#">Salvar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($id)) $id = 0; //verificar se id é vazio ?>

        <script>

            function verificarCpf(cpf) {
                //ajax verificação CPF
                //faz o get para o arquivo indicado e a variável e o retorno
                $.get("verificarCpf.php", {
                        cpf: cpf,
                        id: <?= $id; ?>
                    },
                function(dados) {
                    if (dados != "") {
                        // retorno da mensagem da verificação de erro
                        alert(dados);
                        //zera o CPF
                        $("#cpf").val("");
                    }
                })
            };

            $(document).ready(function() {
                $("#data_nascimento").mask("99/99/9999");
                $("#cpf").mask("999.999.999-99");
                $("#telefone1").mask("(99) 9999-9999");
                $("#telefone2").mask("(99) 99999-9999");
                $("#cep").mask("99.999-999");
            });

            $("#cep").blur(function() {
            //pega valor do CEP
            cep = $("#cep").val();
            cep = cep.replace(/\D/g, '');
            if (cep == "") {
                alert("Preencha o CEP");
            } else {
                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                    $("#cidade").val(dados.localidade);
                    $("#estado").val(dados.uf);
                    $("#endereco").val(dados.logradouro);

                    //buscar ID da cidade
                    $.get("buscarCidade.php", {
                            cidade: dados.localidade,
                            estado: dados.uf
                        },
                        function(dados) {
                            if (dados != "Erro") {
                                $("#cidade_id").val(dados) //coloca o Valor de dados
                            } else {
                                alert(dados);
                            }
                        })
                    //focar no endereço
                    $("#endereco").focus();
                })
            }
        })
        </script>
</div>