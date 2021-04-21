<?php
// Verificar se não está logado
// if (!isset($_SESSION['facilita_escola']['id'])) {
//     exit;
// }

// Verificar se existem dados no POST
if ($_POST) {
    include "../config/conexao.php";
    include "functions.php";

    $nome = $login = $senha = $rg = $cpf = $data_nascimento = $data_cadastro =
        $email = $logradouro = $numero  = $cep = $complemento = $telefone1 =
        $telefone2 = $status = $cidade_id = '';
    $status = $_POST["status"];


    foreach ($_POST as $key => $value) {
        $$key = trim($value);
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

    $cidade_id = 3172;

    $pdo->beginTransaction();
    if (empty($id)) {
        $sql = "INSERT INTO pessoa (
                    nome, login, senha, rg, cpf, data_nascimento, 
                    email, logradouro, numero, cep, complemento,
                    telefone1, telefone2, id_cidade, tipo_cadastro, status) 
                VALUES (
                    :nome, :login, :senha, :rg, :cpf, :data_nascimento, 
                    :email, :logradouro, :numero, :cep, :complemento,
                    :telefone1, :telefone2, :cidade_id, :tipo_cadastro, :status)";

        $tipo_cadastro = 3; //1 - ADM, 2 - ALUNO, 3 - PROF
        $status = 1;       // 1 - ATIVO, 0 - INATIVO - Ativo como padrão
        $senha = password_hash($senha, PASSWORD_BCRYPT);

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

        //executar SQL depois de ver qual ele vai passar
        if ($consulta->execute()) {

            $ultimoId = $pdo->lastInsertId();

            $sql2 = "INSERT INTO professor (pessoa_id, formacao)
                    VALUES (:pessoa_id, :formacao)";

            $consulta2 = $pdo->prepare($sql2);
            $consulta2->bindParam(":formacao", $formacao);
            $consulta2->bindParam(":pessoa_id", $ultimoId);

            if (!$consulta2->execute()) {
                $pdo->rollBack();
                echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
                exit;
            }

            //gravar no DB se tudo estiver OK
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/professor';</script>;";
            exit;
        }

        //edição
    } else {
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
                    status = :status,
                    id_cidade = :cidade_id
                WHERE id = :id 
                LIMIT 1";

        $senha = password_hash($senha, PASSWORD_BCRYPT);



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

        if ($consulta->execute()) {


            $sql2 = "UPDATE professor
            SET formacao = :formacao
            WHERE pessoa_id = :id";

            $consulta2 = $pdo->prepare($sql2);
            $consulta2->bindParam(":formacao", $formacao);
            $consulta2->bindParam(":id", $id);

            if (!$consulta2->execute()) {
                $pdo->rollBack();
                echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
                echo  $consulta2->errorInfo()[2];

                exit;
            }

            //gravar no DB se tudo estiver OK
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/professor';</script>;";
            exit;
        }
    }

    echo $consulta->errorInfo()[2] . '-' . $consulta2->errorInfo()[2] .  '~>ultimoID = ' . print($ultimoId);
    echo  'var_dump: ' . var_dump($ultimoId) . ' - print: ' . print($ultimoId);
    exit;
}

echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
