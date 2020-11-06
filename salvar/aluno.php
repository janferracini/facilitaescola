<?php

// Verificar se existem dados no POST
if ($_POST) {
    include "../config/conexao.php";
    include "../functions.php";

    $id = $nome = $rg = $cpf = $data_nascimento = $senha = $email = $login = 
    // tabela aluno
    $matricula = $foto = $serie = $pessoa_id = 
    // tabela endereço
    $logradouro = $numero = $cep = $complemento = $cidade_id = "";

    foreach ($_POST as $key =>$value) {
        $$key = trim($value);
    }

    if (empty ($matricula) ) {
        echo "<script>alert('Preencha o campo CGM');history.back();</script>";
        exit;
    }

    if (empty ($nome) ) {
        echo "<script>alert('Preencha o campo Nome');history.back();</script>";
        exit;
    }

    if (empty ($rg) ) {
        echo "<script>alert('Preencha o campo RG');history.back();</script>";
        exit;
    }

    if (empty ($data_nascimento) ) {
        echo "<script>alert('Preencha o campo Data de Nascimento');history.back();</script>";
        exit;
    }

    if (empty ($cep) ) {
        echo "<script>alert('Preencha o campo CEP');history.back();</script>";
        exit;
    }

    // if (empty ($cidade_id) ) {
    //     echo "<script>alert('Preencha o campo Cidade');history.back();</script>";
    //     exit;
    // }

    if (empty ($logradouro) ) {
        echo "<script>alert('Preencha o campo Endereço');history.back();</script>";
        exit;
    }

    if (empty ($numero) ) {
        echo "<script>alert('Preencha o campo Número');history.back();</script>";
        exit;
    }

    // if (empty ($telefone) ) {
    //     echo "<script>alert('Preencha o campo Telefone');history.back();</script>";
    // }

    if (empty ($serie) ) {
        echo "<script>alert('Preencha o campo Série');history.back();</script>";
        exit;
    }

    if (empty ($login) ) {
        echo "<script>alert('Preencha o campo Login');history.back();</script>";
        exit;
    }

    if (empty ($senha) ) {
        echo "<script>alert('Preencha o campo senha');history.back();</script>";
        exit;
    }

    $pdo->beginTransaction();

    if (empty ($id) ) {
        $sql = "INSERT INTO aluno
            (matricula, foto, serie, pessoa_id)
        VALUES 
            (:matricula, :foto, :serie, :pessoa_id)";
        
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam("matricula", $matricula);
        $consulta->bindParam("foto", $foto);
        $consulta->bindParam("pessoa_id", $pessoa_id);
    } else {
            $sql = "UPDATE aluno
            SET 
            matricula = :matricula,
            nome    = :nome,
            rg      = :rg,
            cpf     = :cpf,
            data_nascimento = :data_nascimento,
            cep             = :cep,
            cidade_id       = :cidade_id,
            logradouro      = :logradouro,
            numero          = :numero,
            complemento     = :complemento,
            telefone        = :telefone,
            pessoa_id       = :pessoa_id,
            foto    = :foto,
            serie   = :serie,
            login   = :login,
            senha   = :senha
            WHERE id = :id
            LIMIT 1";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam("matricula", $matricula);
        $consulta->bindParam("nome", $nome);
        $consulta->bindParam("rg", $rg);
        $consulta->bindParam("cpf", $cpf);
        $consulta->bindParam("data_nascimento", $data_nascimento);
        $consulta->bindParam("cep", $cep);
        $consulta->bindParam("cidade_id", $cidade_id);
        $consulta->bindParam("logradouro", $logradouro);
        $consulta->bindParam("numero", $numero);
        $consulta->bindParam("complemento", $complemento);
        // $consulta->bindParam("telefone", $telefone);
        $consulta->bindParam("foto", $foto);
        $consulta->bindParam("serie", $serie);
        $consulta->bindParam("login", $login);
        $consulta->bindParam("senha", $senha);
        $consulta->bindParam("pessoa_id", $pessoa_id);
    }

    if ($consulta->execute()) {
        $pdo->commit();
        echo "<script>alert('Registro salvo');location.href='listar/aluno'</script>";
        exit;
    }
    echo $consulta->errorInfo()[2];
    exit;
}
// Mensagem de erro
// Javascript - mensagem alert
// Retornar history.back()
echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";