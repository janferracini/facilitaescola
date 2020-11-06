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
            FROM pessoa pe
            INNER JOIN aluno a ON (a.pessoa_id = pe.id),
            INNER JOIN endereco e ON (e.id = cidade_id)
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
                <h1 class="m-0 text-dark">Cadastro de Aluno</h1>
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
        <div class="row">
            <!-- LINHA 1 -->
            <div class="col-12 col-md-3">
                <label for="CGM"> CGM </label>
                <input type="number" class="form-control" id="cgm" name="CGM" required data-parsley-required-message="Preencha com o número do CGM do aluno" 
                placeholder="Código Geral de Matrícula" value="<?= $matricula ?>">
            </div>

            <div class="col-12 col-md-3">
                <label for="nome"> Login </label>
                <input type="text" class="form-control" id="login" name="login" required data-parsley-required-message="Preencha o nome do login" 
                placeholder="Insira com o login de acesso" value="<?= $login ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="nome"> Nome Completo </label>
                <input type="text" class="form-control" id="nome" name="nome" required data-parsley-required-message="Preencha o nome do aluno" value="<?= $nome?>">
            </div>

            <!-- LINHA 2 -->
            <div class="col-12 col-md-4">
                <label for="CPF"> CPF </label>
                <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $cpf?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="rg"> RG </label>
                <input type="text" class="form-control" id="rg" name="rg" required data-parsley-required-message="Preencha o RG" value="<?= $rg ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="dataNascimento"> Data De Nascimento </label>
                <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" required data-parsley-required-message="Preencha a data de nascimento" value="<?= $data_nascimento?>">
            </div>

            <!-- LINHA 3-->
            <div class="col-12 col-md-3">
                <label for="cep"> CEP </label>
                <input type="text" class="form-control" id="cep" name="cep" required data-parsley-required-message="Preencha com um CEP válido" value="<?= $cep ?>">
            </div>

            <div class="col-12 col-md-5">
                <label for="cidade"> Cidade </label>
                <input type="text" class="form-control" id="cidade" name="cidade" required data-parsley-required-message="Preencha a cidade" value="<?= $cidade_id ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="bairro"> Bairro </label>
                <input type="text" class="form-control" id="bairro" name="bairro" required data-parsley-required-message="Preencha o bairro">
            </div>

            <!-- LINHA 4 -->
            <div class="col-12 col-md-8">
                <label for="endereco"> Endereço </label>
                <input type="text" class="form-control" id="endereco" name="endereco" required data-parsley-required-message="Preencha o endereço" value="<?= $logradouro?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="numero"> Número </label>
                <input type="text" class="form-control" id="numero" name="numero" required data-parsley-required-message="Preencha com o número da residência" placeholder="Insira o número da residência">
            </div>

            <!-- LINHA 5 -->
            <div class="col-12 col-md-12">
                <label for="complemento"> Complemento </label>
                <input type="text" class="form-control" id="complement" name="completo">
            </div>

            <!-- LINHA 6 -->
            <div class="col-12 col-md-4">
                <label for="telefone"> Telefone </label>
                <input type="text" class="form-control" id="telefone" name="telefone" required data-parsley-required-message="Preencha com o número de telefone">
            </div>

            <div class="col-12 col-md-4">
                <label for="celular"> Celular/WhatsApp </label>
                <input type="text" class="form-control" id="celular" name="telefone" required data-parsley-required-message="Preencha com o número de celular/whatsapp">
            </div>

            <div class="col-12 col-md-4">
                <label for="foto"> Foto </label>
                <input type="file" class="form-control" id="foto" name="foto" accept=".jpeg, .jpg">
            </div>

            <!-- LINHA 7 -->
            <div class="col-12 col-md-4">
                <label for="turma"> Turma </label> <!-- colocar dropdown-->
                <input type="text" class="form-control" id="turma" name="turma" list="listaTurma" required data-parsley-required-message="Preencha com a turma do aluno" value="<?php
                    if (!empty($turma)) echo "$serie - $descricao - $ano";
                    ?>">

                <!-- LISTAGEM DE TURMAS -->
                <datalist id="listaTurma">
                    <?php
                    $sql = "SELECT id, serie, descricao, ano
                                FROM turma
                                ORDER BY id";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ($d = $consulta->fetch(PDO::FETCH_OBJ)) {
                        //separar os dados
                        $id        = $d->id;
                        $serie     = $d->serie;
                        $descricao = $d->descricao;
                        $ano       = $d->ano;

                        echo '<option value=" ' . $serie . ' - ' . $descricao . ' - ' . $ano .' ">';
                    };
                    ?>
                </datalist>
            </div>

            <div class="col-12 col-md-4">
                <!-- colocar dropdown-->
                <label for="periodo"> Período </label>
                <input type="text" class="form-control" list="listaPeriodo" id="periodo" name="periodo" require data-parsley-required-message="Selecione o período" value="<?php
                    if (!empty($periodo_id)) echo "$periodo";
                ?>">

                <!-- LISTAGEM DE PERÍODOS -->
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
                        echo '<option value=" ' . $periodo . '">';
                    };
                    ?>
                </datalist>
            </div>

            <div class="col-12 col-md-4">
                <label for="nome"> Senha </label>
                <input type="text" class="form-control" id="login" name="login" 
                require data-parsley-required-message="Preencha o nome do login" placeholder="Insira com a senha inicial de acesso">
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-success margin">
            <i class="fas fa-check"></i> Gravar Dados
        </button>
    </form>

    <script>
        $(document).ready(function() {
            $("#cpf").inputmask("999.999.999-99");
        })
    </script>
</div>