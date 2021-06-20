<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

// Verificar se existem dados no POST
if ($_POST) {
    include "../config/conexao.php";
    include "functions.php";

    $nome = $login = $senha = $rg = $cpf = $data_nascimento = $data_cadastro =
        $email = $logradouro = $numero  = $cep = $complemento = $telefone1 = $telefone2 =
        $cidade_id = '';

    $status = $_POST["status"];


    foreach ($_POST as $key => $value) {
        $$key = trim(strip_tags($value));
    }

    if (empty($nome)) {
        echo "<script>alert('Preencha o Nome');history.back();</script>";
        exit;
    }
    if (empty($login)) {
        echo "<script>alert('Preencha o Login');history.back();</script>";
        exit;
    }
    if (empty($data_nascimento)) {
        echo "<script>alert('Preencha a Data de Nascimento');history.back();</script>";
        exit;
    }
    if (empty($logradouro)) {
        echo "<script>alert('Preencha o Endereço');history.back();</script>";
        exit;
    }
    if (empty($numero)) {
        echo "<script>alert('Preencha o Numero');history.back();</script>";
        exit;
    }
    if (empty($cep)) {
        echo "<script>alert('Preencha o CEP');history.back();</script>";
        exit;
    }
    if (empty($telefone1)) {
        echo "<script>alert('Preencha o Telefone obrigatório');history.back();</script>";
        exit;
    }

    if (empty($id) && empty($senha)) {
        echo "<script>alert('Preencha a Senha');history.back();</script>";
        exit;
    }

    //iniciar uma transação com o DB toda alteração pra baixo, só será feito após o commit
    $pdo->beginTransaction();
    if (empty($id)) {
        //caso INSERIR
        $sql = "SELECT cpf 
                FROM pessoa
                WHERE cpf = :cpf
            LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);
        if (!empty($dados->cpf)) {
            echo "<script>alert('CPF já cadastrado');history.back();</script>";
            exit;
        }

        $sql = "SELECT login 
                    FROM pessoa
                    WHERE login = :login
                LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":login", $login);
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);
        if (!empty($dados->login)) {
            echo "<script>alert('Login já cadastrado');history.back();</script>";
            exit;
        }



        $sql = "INSERT INTO pessoa (
                    nome, login, senha, rg, cpf, data_nascimento, 
                    email, logradouro, numero, cep, complemento,
                    telefone1, telefone2, id_cidade, tipo_cadastro, status) 
            VALUES (
                    :nome, :login, :senha, :rg, :cpf, :data_nascimento, 
                    :email, :logradouro, :numero, :cep, :complemento,
                    :telefone1, :telefone2, :cidade_id, :tipo_cadastro, :status)";

        $tipo_cadastro = 1; //1 - ADM, 2 - ALUNO, 3 - PROF
        $status = 1;       // 1 - ATIVO, 0 - INATIVO - Ativo como padrão
        $senha = password_hash($senha, PASSWORD_BCRYPT);
        $login = strtolower($login);

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":login", $login);
        $consulta->bindParam(":senha", $senha);
        $consulta->bindParam(":rg", $rg);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->bindParam(":data_nascimento", $data_nascimento);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":logradouro", $logradouro);
        $consulta->bindParam(":numero", $numero);
        $consulta->bindParam(":cep", $cep);
        $consulta->bindParam(":complemento", $complemento);
        $consulta->bindParam(":telefone1", $telefone1);
        $consulta->bindParam(":telefone2", $telefone2);
        $consulta->bindParam(":cidade_id", $cidade_id);
        $consulta->bindParam(":tipo_cadastro", $tipo_cadastro);
        $consulta->bindParam(":status", $status);
    } else {

        //caso EDITAR
        $sql = "SELECT cpf 
                FROM pessoa
                WHERE cpf = :cpf AND id <> :id
            LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);
        if (!empty($dados->cpf)) {
            echo "<script>alert('CPF já cadastrado');history.back();</script>";
            exit;
        }

        $sql = "SELECT login 
                    FROM pessoa
                    WHERE login = :login
                LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":login", $login);
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);
        if (!empty($dados->login)) {
            echo "<script>alert('Login já cadastrado');history.back();</script>";
            exit;
        }

        $sql = "UPDATE pessoa
                SET nome = :nome,
                    login = :login,
                    senha = :senha,
                    rg = :rg,
                    cpf = :cpf,
                    data_nascimento = :data_nascimento, 
                    email = :email,
                    logradouro = :logradouro,
                    numero = :numero,
                    cep = :cep,
                    complemento = :complemento,
                    telefone1 = :telefone1,
                    telefone2 = :telefone2,
                    id_cidade = :cidade_id,
                    status = :status
                WHERE id = :id 
                LIMIT 1";

        $senha = password_hash($senha, PASSWORD_BCRYPT);
        $login = strtolower($login);

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":login", $login);
        $consulta->bindParam(":senha", $senha);
        $consulta->bindParam(":rg", $rg);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->bindParam(":data_nascimento", $data_nascimento);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":logradouro", $logradouro);
        $consulta->bindParam(":numero", $numero);
        $consulta->bindParam(":cep", $cep);
        $consulta->bindParam(":complemento", $complemento);
        $consulta->bindParam(":telefone1", $telefone1);
        $consulta->bindParam(":telefone2", $telefone2);
        $consulta->bindParam(":cidade_id", $cidade_id);
        $consulta->bindParam(":status", $status);
        $consulta->bindParam(":id", $id);
    }

    //executar SQL depois de ver qual ele vai passar
    if ($consulta->execute()) {

        //gravar no DB se tudo estiver OK
        $pdo->commit();
        echo "<script>alert('Registro salvo');location.href='listar/admin';</script>;";
        exit;
    }
    echo 'ERRO: ' . $consulta->errorInfo()[2];
    exit;
}
// Mensagem de erro
// Javascript - mensagem alert
// Retornar history.back()
echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
