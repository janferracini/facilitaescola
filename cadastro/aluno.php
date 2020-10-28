<?php
//verificar se não está logado
// if (!isset($_SESSION["hqs"]["id"])) {
//     exit;
// }

if (!isset($id)) $id = "";

$matricula = $login = $nome = $cpf = $rg = $data_nascimento = $logradouro = $cep = $cidade_id = $bairro = 
$foto = $serie = $turma = $pessoa_id = '';

if (!empty($id)) {
    $sql = "SELECT a.id,
                   a.matricula,
                   a.foto,
                   a.serie,
                   pe.nome,
                   pe.rg,
                   pe.cpf,
                   pe.data_nascimento,
                   pe.login,
                   pe.senha,
                   t.serie,
                   t.periodo_id,
                   pe.id pessoa_id
            FROM aluno a
            INNER JOIN pessoa pe ON (pe.id = a.pessoa_id),
            INNER JOIN turma t ON (
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
    $matricula  = $dados->matricula;
    $login      = $dados->login;
    $cpf        = $dados->cpf;
    $rg         = $dados->rg;
    $data_nascimento =  $dados->data_nascimento;
    $cep        = $dados->cep;
    $cidade_id  = $dados->cidade_id;
    $bairro     = $dados->bairro;
    $foto       = $dados->foto;
    $serie      = $dados->serie;
    $turma      = $dados->turma;
    $pessoa_id  = $dados->pessoa_id;
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
                <input type="number" class="form-control" id="cgm" name="CGM" require data-parsley-required-message="Preencha com o número do CGM do aluno" 
                placeholder="Código Geral de Matrícula" value="<?= $matricula ?>">
            </div>

            <div class="col-12 col-md-3">
                <label for="nome"> Login </label>
                <input type="text" class="form-control" id="login" name="login" require data-parsley-required-message="Preencha o nome do login" 
                placeholder="Insira com o login de acesso" value="<?= $login ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="nome"> Nome Completo </label>
                <input type="text" class="form-control" id="nome" name="nome" require data-parsley-required-message="Preencha o nome do aluno" value="<?= $nome?>">
            </div>

            <!-- LINHA 2 -->
            <div class="col-12 col-md-4">
                <label for="CPF"> CPF </label>
                <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $cpf?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="rg"> RG </label>
                <input type="text" class="form-control" id="rg" name="rg" require data-parsley-required-message="Preencha o RG" value="<?= $rg ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="dataNascimento"> Data De Nascimento </label>
                <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" require data-parsley-required-message="Preencha a data de nascimento" value="<?= $data_nascimento?>">
            </div>

            <!-- LINHA 3-->
            <div class="col-12 col-md-3">
                <label for="cep"> CEP </label>
                <input type="text" class="form-control" id="cep" name="cep" require data-parsley-required-message="Preencha com um CEP válido" value="<?= $cep ?>">
            </div>

            <div class="col-12 col-md-5">
                <label for="cidade"> Cidade </label>
                <input type="text" class="form-control" id="cidade" name="cidade" require data-parsley-required-message="Preencha a cidade" value="<?= $cidade_id?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="bairro"> Bairro </label>
                <input type="text" class="form-control" id="bairro" name="bairro" require data-parsley-required-message="Preencha o bairro" value="<?= $bairro?>">
            </div>

            <!-- LINHA 4 -->
            <div class="col-12 col-md-8">
                <label for="endereco"> Endereço </label>
                <input type="text" class="form-control" id="endereco" name="endereco" require data-parsley-required-message="Preencha o endereço" value="<?= $logradouro?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="numero"> Número </label>
                <input type="text" class="form-control" id="numero" name="numero" require data-parsley-required-message="Preencha com o número da residência" placeholder="Insira o número da residência">
            </div>

            <!-- LINHA 5 -->
            <div class="col-12 col-md-12">
                <label for="complemento"> Complemento </label>
                <input type="text" class="form-control" id="complement" name="completo">
            </div>

            <!-- LINHA 6 -->
            <div class="col-12 col-md-4">
                <label for="telefone"> Telefone </label>
                <input type="text" class="form-control" id="telefone" name="telefone" require data-parsley-required-message="Preencha com o número de telefone">
            </div>

            <div class="col-12 col-md-4">
                <label for="celular"> Celular/WhatsApp </label>
                <input type="text" class="form-control" id="celular" name="telefone" require data-parsley-required-message="Preencha com o número de celular/whatsapp">
            </div>

            <div class="col-12 col-md-4">
                <label for="foto"> Foto </label>
                <input type="file" class="form-control" id="foto" name="foto" accept=".jpeg, .jpg">
            </div>

            <!-- LINHA 7 -->
            <div class="col-12 col-md-4">
                <label for="turma"> Turma </label> <!-- colocar dropdown-->
                <input type="text" class="form-control" id="turma" name="turma" list="listaTurma" require data-parsley-required-message="Preencha com a turma do aluno" value="<?php
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
</div>