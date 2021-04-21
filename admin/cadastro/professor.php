<?php

if (!isset($id)) $id = "";

// tabela pessoa
$nome = $login = $senha = $rg = $cpf = $data_nascimento = $data_cadastro =
    $email = $logradouro = $numero  = $cep = $complemento = $telefone1 = $telefone2 =
    $status = $cidade_id = $cidade = $estado = $idprof = '';

if (!empty($id)) {
    $sql = "SELECT  p.id pid, p.*,
                    c.*, pr.id prid, pr.*
            FROM pessoa p
            INNER JOIN cidade c ON (c.id = p.id_cidade)
            INNER JOIN professor pr ON (pr.pessoa_id = p.id)
            WHERE p.id = :id
            LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    // caso não existir professor cadastrado
    if (empty($dados->id)) {
        echo "<p class='alert alert-danger'> Professor não cadastrado </p>";
    } else {
        $id         = $dados->pid;
        $nome       = $dados->nome;
        $rg         = $dados->rg;
        $cpf        = $dados->cpf;
        $data_nascimento = $dados->data_nascimento;
        $email       = $dados->email;
        $login       = $dados->login;
        $logradouro  = $dados->logradouro;
        $numero      = $dados->numero;
        $cep         = $dados->cep;
        $complemento = $dados->complemento;
        $cidade_id   = $dados->id_cidade;
        $cidade      = $dados->cidade;
        $telefone1  = $dados->telefone1;
        $telefone2  = $dados->telefone2;
        $estado     = $dados->estado;
        $status      = $dados->status;
        $formacao   = $dados->formacao;
        $idprof     = $dados->prid;
    }
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Cadastro de Professor</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container">

    <div class="float-right">
        <a href="listar/professor" class="btn btn-outline-info">Listar Professores</a>
    </div>

    <div class="clearfix"></div> <!-- Ignora os floats -->

    <form action="salvar/professor" name="formCadastro" method="post" data-parsley-validate enctype="multipart/form-data" role="form">
        <div class="row mb-3">

            <input type="hidden" class="form-control" name="id" id="id" readonly value="<?= $id ?>">

            <!-- LINHA 1 -->
            <div class="col-12 col-md-8">
                <label for="nome"> Nome Completo </label>
                <input type="text" class="form-control" id="nome" name="nome" required data-parsley-required-message="Preencha o nome" value="<?= $nome ?>">
            </div>
            <div class="col-12 col-md-4">
                <label for="status"> Status </label>
                <select id="status" name="status" class="form-control ">

                    <?php
                    if ($status == 1 || (empty($id))) {
                        echo "
                        <option value='1' selected>Ativo</option>
                        <option value='0'>Inativo</option>";
                    } else if ($status == 0) {
                        echo " 
                        <option value='1'>Ativo</option>
                        <option value ='0' selected>Inativo</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- LINHA 2 -->
            <div class="col-12 col-md-4">
                <label for="login"> Login </label>
                <input type="text" class="form-control" id="login" name="login" required data-parsley-required-message="Preencha o nome do login" placeholder="Insira com o login de acesso" value="<?= $login ?>">
            </div>

            <div class="col-12 col-md-8">
                <label for="email"> E-mail </label>
                <input type="email" class="form-control" id="email" name="email" required data-parsley-required-message="Preencha com um e-mail válido" placeholder="Digite um e-mail válido" value="<?= $email ?>">
            </div>

            <!-- LINHA 3-->
            <div class="col-12 col-md-4">
                <label for="rg"> RG </label>
                <input type="text" class="form-control" id="rg" name="rg" required data-parsley-required-message="Preencha o RG" value="<?= $rg ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="cpf"> CPF </label>
                <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $cpf ?>" onblur="verificarCpf(this.value)">

            </div>

            <div class="col-12 col-md-4">
                <label for="data_nascimento"> Data De Nascimento </label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required data-parsley-required-message="Preencha a data de nascimento" value="<?= $data_nascimento ?>">
            </div>

            <!-- LINHA 4 -->
            <div class="col-12 col-md-4">
                <label for="cep"> CEP </label>
                <input type="text" class="form-control" id="cep" name="cep" required data-parsley-required-message="Preencha com um CEP válido" value="<?= $cep ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="cidade"> Cidade</label>
                <input type="text" class="form-control" id="cidade" required data-parsley-required-message="Selecione a cidade" value="<?= $cidade ?>">

                <input type="hidden" class="form-control" id="cidade_id" name="cidade_id" required data-parsley-required-message="Selecione a cidade" readonly value="<?= $cidade_id ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="cidade"> Estado </label>
                <input type="text" class="form-control" id="estado" required data-parsley-required-message="Selecione o estado" value="<?= $estado ?>">
            </div>

            <!-- LINHA 5 -->
            <div class="col-12 col-md-8">
                <label for="logradouro"> Endereço Completo</label>
                <input type="text" class="form-control" id="logradouro" name="logradouro" required data-parsley-required-message="Preencha o endereço" value="<?= $logradouro ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="numero"> Número </label>
                <input type="text" class="form-control" id="numero" name="numero" required data-parsley-required-message="Preencha com o número da residência" placeholder="Insira o número da residência" value="<?= $numero ?>">
            </div>

            <!-- LINHA 6 -->
            <div class="col-12 col-md-12">
                <label for="complemento"> Complemento </label>
                <input type="text" class="form-control" id="complemento" name="complemento" value="<?= $complemento ?>">
            </div>

            <!-- LINHA 7 -->
            <div class="col-12 col-md-6">
                <label for="telefone1"> Telefone Obrigatório</label>
                <input type="text" class="form-control" id="telefone1" name="telefone1" required data-parsley-required-message="Preencha com o número de telefone" value="<?= $telefone1 ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="telefone2"> Telefone Opcional </label>
                <input type="text" class="form-control" id="telefone2" name="telefone2" value="<?= $telefone2 ?>">
            </div>

            <div class="clearfix"></div>

            <!-- LINHA 7 -->
            <div class="col-12 col-md-6">
                <label for="senha"> Senha </label>
                <input type="password" class="form-control" id="senha" name="senha" require data-parsley-required-message="Insira uma senha" placeholder="Insira com a senha inicial de acesso">
            </div>

            <div class="col-12 col-md-6">
                <label for="confirmaSenha">Confirmar Senha </label>
                <input type="password" class="form-control" id="confirmaSenha" name="confirmaSenha" require data-parsley-required-message="Insira a senha novamente" placeholder="Insira com a senha inicial de acesso">
            </div>

            <div class="col-12 col-md-12 mt-3 text-dark">
                <hr>
                <h3>Formação</h3>
            </div>

            <div class="col-12 col-md-12 mt-3">
                <input type="hidden" class="form-control" name="idprof" id="idprof" readonly value="<?= $idprof ?>">
                <textarea type="text" style="height: 100px" class="form-control" id="formacao" name="formacao" required data-parsley-required-message="Preencha esse campo"><?php if (!empty($formacao)) echo $formacao ?></textarea>
            </div>
        </div>
        <div class="float-right">
            <button type="submit" class="btn btn-outline-laranja margin">
                <i class="fas fa-check"></i> Gravar Dados
            </button>
        </div>
        <div class="clearfix"></div> <!-- Ignora os floats -->
    </form>

    <?php if (empty($id)) $id = 0; //verificar se id é vazio 
    ?>

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

        // verificador de senha no update
        function verificarSenha() {
            if ($('#senha').val() != $('#senha2').val()) {
                $('#senha').val('')
                $('#senha2').val('')
                $('#senha2').removeClass('is-valid')
                $('#senha2').addClass('is-invalid')
                return alert('As senhas devem ser iguais.')
            }
            $('#senha2').removeClass('is-invalid')
            $('#senha2').addClass('is-valid')
        }

        $(document).ready(function() {
            // $("#data_nascimento").mask("99/99/9999");
            $("#cpf").mask("000.000.000-00");
            $('#telefone1').blur(function(event) {
                if ($(this).val().length == 15) {
                    $('#telefone1').mask('(00) 00000-0009');
                } else {
                    $('#telefone1').mask('(00) 0000-00009');
                }
            });
            $("#telefone2").mask("(00) 0000-00009");
            $('#telefone2').blur(function(event) {
                if ($(this).val().length == 15) {
                    $('#telefone2').mask('(00) 00000-0009');
                } else {
                    $('#telefone2').mask('(00) 0000-00009');
                }
            });
            $("#cep").mask("00.000-000");
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
                    $("#logradouro").val(dados.logradouro);

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
                    $("#logradouro").focus();
                })
            }
        })
    </script>
</div>