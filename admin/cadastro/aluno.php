<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if (!isset($id)) $id = "";

$nome = $login = $senha = $rg = $cpf = $data_nascimento = $data_cadastro =
    $email = $logradouro = $numero  = $cep = $complemento = $telefone1 = $telefone2 =
    $status = $cidade_id = $cidade = $estado = $matricula = $data_matricula = $pessoa_id =
    $turma_matricula_id = $matricula_id = $serie = $descricao = $ano = $periodo = '';

if (!empty($id)) {
    $sql = "SELECT  p.id pid, p.*,
                    c.*,
                    m.id mid, m.*,
                    tm.id tmid, tm.*,
                    t.id tid, t.*,
                    pd.*
                FROM pessoa p
                INNER JOIN cidade c ON (c.id = p.id_cidade)
                INNER JOIN matricula m ON (m.pessoa_id = p.id)
                INNER JOIN turma_matricula tm ON (tm.matricula_id = m.id)
                INNER JOIN turma t ON (t.id = tm.turma_id)
                INNER JOIN periodo pd ON (pd.id = t.periodo_id)
                WHERE p.id = :id
                LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (empty($dados->id)) {
        echo "<p class='alert alert-danger'> Aluno não cadastrado '$id' </p>";
    } else {
        $id         = $dados->pid;
        $nome       = $dados->nome;
        $status     = $dados->status;
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
        $telefone1   = $dados->telefone1;
        $telefone2   = $dados->telefone2;
        $estado      = $dados->estado;
        $matricula_id    = $dados->mid;
        $matricula       = $dados->matricula;
        $data_matricula  = $dados->data_matricula;
        $pessoa_id       = $dados->id;
        $tmid = $dados->tmid;
        $serie     = $dados->serie;
        $descricao = $dados->descricao;
        $ano       = $dados->ano;
        $periodo   = $dados->periodo;
        $turma_id  = $dados->tid;
    }
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div>
                <h1 class="m-0 text-dark">Cadastro de Aluno</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">

    <div class="float-right">
        <a href="listar/aluno" class="btn btn-outline-info">Listar Alunos</a>
    </div>

    <div class="clearfix"></div>

    <form action="salvar/aluno" name="formCadastro" method="post" data-parsley-validate enctype="multipart/form-data" role="form">
        <div class="row mb-3">
            <input type="hidden" class="form-control" name="id" id="id" readonly value="<?= $id ?>">

            <div class="col-12 col-md-8">
                <label for="nome"> Nome Completo </label>
                <input type="text" autocomplete="off" class="form-control" id="nome" name="nome" required data-parsley-required-message="Preencha o nome" value="<?= $nome ?>">
            </div>
            <div class="col-12 col-md-4">
                <label for="status"> Status </label>
                <select id="status" autocomplete="off" name="status" class="form-control ">

                    <?php
                    if ($status == 1 || empty($id)) {
                        echo "
                        <option value='1' selected>Ativo</option>
                        <option value='0'>Inativo</option>";
                    } else if ($status == 0) {
                        echo " 
                        <option value='1' >Ativo</option>
                        <option value ='0' selected>Inativo</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-12 col-md-4">
                <label for="login"> Login </label>
                <input type="text" autocomplete="off" class="form-control" id="login" name="login" required data-parsley-required-message="Preencha o nome do login" placeholder="Insira com o login de acesso" value="<?= $login; ?>">
            </div>

            <div class="col-12 col-md-8">
                <label for="email"> E-mail </label>
                <input type="email" autocomplete="off" class="form-control" id="email" name="email" required data-parsley-required-message="Preencha com um e-mail válido" placeholder="Digite um e-mail válido" value="<?= $email; ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="rg"> RG </label>
                <input type="text" autocomplete="off" class="form-control" id="rg" name="rg" value="<?= $rg; ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="cpf"> CPF </label>
                <input type="text" autocomplete="off" class="form-control" name="cpf" id="cpf" value="<?= $cpf; ?>" placeholder="000.000.000-00" onblur="if(this.value) verificarCpf(this.value)">
            </div>

            <div class="col-12 col-md-4">
                <label for="data_nascimento"> Data De Nascimento </label>
                <input type="date" autocomplete="off" class="form-control" id="data_nascimento" name="data_nascimento" required data-parsley-required-message="Preencha a data de nascimento" value="<?= $data_nascimento; ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="cep"> CEP </label>
                <input type="text" autocomplete="off" class="form-control" id="cep" name="cep" required data-parsley-required-message="Preencha com um CEP válido" value="<?= $cep; ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="cidade"> Cidade</label>
                <input type="text" autocomplete="off" class="form-control" id="cidade" required data-parsley-required-message="Selecione a cidade" value="<?= $cidade ?>">
                <input type="hidden" class="form-control" id="cidade_id" name="cidade_id" required data-parsley-required-message="Selecione a cidade" readonly value="<?= $cidade_id ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="cidade"> Estado </label>
                <input type="text" autocomplete="off" class="form-control" id="estado" required data-parsley-required-message="Selecione o estado" value="<?= $estado; ?>">
            </div>

            <div class="col-12 col-md-8">
                <label for="logradouro"> Endereço Completo </label>
                <input type="text" autocomplete="off" class="form-control" id="logradouro" name="logradouro" required data-parsley-required-message="Preencha o endereço" value="<?= $logradouro; ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="numero"> Número </label>
                <input type="text" autocomplete="off" class="form-control" id="numero" name="numero" required data-parsley-required-message="Preencha com o número da residência" placeholder="Insira o número da residência" value="<?= $numero; ?>">
            </div>

            <div class="col-12 col-md-12">
                <label for="complemento"> Complemento </label>
                <input type="text" autocomplete="off" class="form-control" id="complemento" name="complemento" value="<?= $complemento; ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="telefone1"> Telefone Obrigatório </label>
                <input type="text" autocomplete="off" class="form-control" id="telefone1" name="telefone1" required data-parsley-required-message="Preencha com o número de telefone" value="<?= $telefone1; ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="telefone2"> Telefone Opcional </label>
                <input type="text" autocomplete="off" class="form-control" id="telefone2" name="telefone2" value="<?= $telefone2; ?>">
            </div>

            <div class="col-12 col-md-6">
                <?php
                $r = 'required data-parsley-required-message="Insira uma senha" placeholder="Insira a senha inicial de acesso';
                if (!empty($id)) $r = 'placeholder="Digite a senha caso queira trocar';
                ?>
                <label for="senha"> Senha </label>

                <input type="password" maxlength="12" minlength="6" autocomplete="off" class="form-control" id="senha" name="senha" <?= $r; ?> ">
            </div>

            <div class=" col-12 col-md-6">
                <?php
                $r = 'required data-parsley-required-message="Insira uma senha" onblur="verificarSenha(this.value)" placeholder="Repita a senha inicial de acesso';
                if (!empty($id)) $r = 'placeholder="Repita a senha caso queira trocar';
                ?>
                <label for="confirmaSenha">Confirmar Senha </label>
                <input type="password" maxlength="12" minlength="6" autocomplete="off" class="form-control" id="senha2" name="senha2" <?= $r; ?> ">
            </div>

            <div class=" col-12 col-md-12 mt-3 text-dark">
                <hr>
                <h3>Matrícula</h3>

            </div>

            <div class="col-12 col-md-4">
                <label for="matricula">Número da matrícula</label>
                <input type="hidden" class="form-control" name="matricula_id" id="matricula_id" readonly value="<?= $matricula_id ?>">
                <input type="text" autocomplete="off" class="form-control" id="matricula" name="matricula" require data-parsley-required-message="Insira o número da matrícula" value="<?= $matricula; ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="data_matricula">Data da matrícula </label>
                <input type="date" autocomplete="off" class="form-control " id="data_matricula" name="data_matricula" require data-parsley-required-message="Insira a data de matrícula" value="<?= $data_matricula; ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="turma">Turma</label>
                <input id="turma_id" autocomplete="off" name="turma_id" class="form-select" list="listaTurma" data-parsley-required-message="Selecione a turma" value="<?php if (!empty($id)) echo "$turma_id - $serie $descricao / $periodo ($ano)"; ?>">
                <datalist id="listaTurma">
                    <?php
                    $sql = "SELECT t.*,t.id tid, p.*
                                        FROM turma t
                                        INNER JOIN periodo p ON (p.id = t.periodo_id)
                                        WHERE status = 1
                                        ORDER BY serie";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                        $serie     = $dados->serie;
                        $descricao = $dados->descricao;
                        $ano       = $dados->ano;
                        $periodo   = $dados->periodo;
                        $turma_id       = $dados->tid;
                        echo '<option value=" ' . $turma_id . ' - ' . $serie . ' ' . $descricao . ' / ' . $periodo . ' (' . $ano . ')">';
                    };
                    ?>
                </datalist>
            </div>
        </div>
        <div class="float-right">
            <button type="submit" class="btn btn-outline-laranja margin">
                <i class="fas fa-check"></i> Gravar Dados
            </button>
        </div>
        <div class="clearfix"></div>
    </form>

    <?php if (empty($id)) $id = 0;
    ?>

    <script>
        function verificarCpf(cpf) {
            $.get("verificarCpf.php", {
                    cpf: cpf,
                    id: <?= $id; ?>
                },
                function(dados) {
                    if (dados != "") {
                        alert(dados);
                        $("#cpf").val("");
                    }
                })
        };

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
            $("#cpf").mask("000.000.000-00");
            $("#telefone1").mask("(00) 0000-00009");
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
            cep = $("#cep").val();
            cep = cep.replace(/\D/g, '');
            if (cep == "") {
                alert("Preencha o CEP");
            } else {
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                    $("#cidade").val(dados.localidade);
                    $("#estado").val(dados.uf);
                    $("#logradouro").val(dados.logradouro);

                    $.get("buscarCidade.php", {
                            cidade: dados.localidade,
                            estado: dados.uf
                        },
                        function(dados) {
                            if (dados != "Erro") {
                                $("#cidade_id").val(dados)
                            } else {
                                alert(dados);
                            }
                        })
                    $("#logradouro").focus();
                })
            }
        })
    </script>
</div>