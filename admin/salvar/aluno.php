<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_POST) {
    include "functions.php";
    include "../config/conexao.php";
    $nome = $login = $senha = $rg = $cpf = $data_nascimento = $data_cadastro =
        $email = $logradouro = $numero  = $cep = $complemento = $telefone1 = $telefone2 =
        $status = $cidade_id = $cidade = $estado = $matricula = $data_matricula = $pessoa_id =
        $turma_matricula = $tmid = $serie = $descricao = $ano = $periodo = $turma_id = '';

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

    if (empty($matricula)) {
        echo "<script>alert('Preencha a Matricula');history.back();</script>";
        exit;
    }

    if (empty($data_matricula)) {
        echo "<script>alert('Preencha a Data de Matricula');history.back();</script>";
        exit;
    }

    $pdo->beginTransaction();

    if (empty($id)) {
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

        $sql = "SELECT matricula 
                FROM matricula
                WHERE matricula = :matricula
                LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":matricula", $matricula);
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if (!empty($dados->matricula)) {
            echo "<script>alert('Matricula já cadastrada');history.back();</script>";
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

        $tipo_cadastro = 2;
        $status = 1;
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

        if ($consulta->execute()) {
            $ultimoId = $pdo->lastInsertId();
            $sql2 = "INSERT INTO matricula (pessoa_id, data_matricula, matricula)
                    VALUES (:pessoa_id, :data_matricula, :matricula)";
            $consulta2 = $pdo->prepare($sql2);
            $consulta2->bindParam(":pessoa_id", $ultimoId);
            $consulta2->bindParam(":data_matricula", $data_matricula);
            $consulta2->bindParam(":matricula", $matricula);

            if ($consulta2->execute()) {
                $ultimoId = $pdo->lastInsertId();
                $sql3 = "INSERT INTO turma_matricula (turma_id, matricula_id)
                        VALUES (:turma_id, :matricula_id)";
                $consulta3 = $pdo->prepare($sql3);
                $consulta3->bindParam(":turma_id", $turma_id);
                $consulta3->bindParam(":matricula_id", $ultimoId);

                if (!$consulta3->execute()) {
                    $pdo->rollBack();
                    echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
                    echo "Consulta 3 :" . $consulta3->errorInfo()[2] . ' - ' . print_r($_POST);
                    exit;
                }
            }

            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/aluno';</script>;";
            exit;
        }
    } else {
        $sql = "SELECT cpf 
                FROM pessoa
                WHERE cpf = :cpf
                AND id <> :id
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
                WHERE login = :login AND id != :id
                LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":login", $login);
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);
        if (!empty($dados->login)) {
            echo "<script>alert('Login já cadastrado');history.back();</script>";
            exit;
        }

        $sql = "SELECT m.*, p.id 
                FROM matricula as m
                INNER JOIN pessoa as p ON (p.id = m.pessoa_id)
                WHERE m.matricula = :matricula AND p.id != :id
                LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":matricula", $matricula);
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);
        if (!empty($dados->matricula)) {
            echo "<script>alert('Matricula já cadastrada');history.back();</script>";
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

        if ($consulta->execute()) {
            $sql2 = "UPDATE matricula
            SET data_matricula = :data_matricula, matricula = :matricula
            WHERE pessoa_id = :id";
            $consulta2 = $pdo->prepare($sql2);
            $consulta2->bindParam(":id", $id);
            $consulta2->bindParam(":data_matricula", $data_matricula);
            $consulta2->bindParam(":matricula", $matricula);

            if ($consulta2->execute()) {
                $sql3 = "UPDATE turma_matricula 
                    SET turma_id = :turma_id, matricula_id = :matricula_id
                    WHERE id = :tmid";

                $consulta3 = $pdo->prepare($sql3);
                $consulta3->bindParam(":turma_id", $turma_id);
                $consulta3->bindParam(":matricula_id", $matricula_id);
                $consulta3->bindParam(":tmid", $tmid);
                if (!$consulta3->execute()) {
                    $pdo->rollBack();
                    echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
                    echo 'Consulta 3: ' . $consulta3->errorInfo()[2] . ' - ' . print_r($_POST);
                    exit;
                }
                $pdo->commit();
                echo "<script>alert('Registro salvo');location.href='listar/aluno';</script>;";
                exit;
            }
        }

        echo $consulta->errorInfo()[2] . '-' . $consulta2->errorInfo()[2] .  $consulta3->errorInfo()[2];
        print_r($_POST);
    }
}

echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
echo "Consulta 1:" . $consulta->errorInfo()[2] . ' - ' . print_r($_POST);
