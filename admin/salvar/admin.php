<?php
// Verificar se não está logado
// if (!isset($_SESSION['facilita_escola']['id'])) {
//     exit;
// }

// Verificar se existem dados no POST
if ($_POST) {
    include "../config/conexao.php";

    $nome = $login = $senha = $rg = $cpf = $datanascimento = $data_cadastro =
    $email = $logradouro = $numero  = $cep = $complemento = $telefone1 = $telefone2 = 
    $foto = $status = $cidade_id = '';


    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if (empty($nome)) {
        echo "<script>alert('Preencha o Nome');history.back();</script>";
        exit;
    }
    //iniciar uma transação com o DB toda alteração pra baixo, só será feito após o commit
    $pdo->beginTransaction();

    if (empty($id)) {
        $sql = "INSERT INTO pessoa (
                    nome, login, senha, rg, cpf, data_nascimento, 
                    email, logradouro, numero, cep, complemento,
                    telefone1, telefone2, id_cidade, tipo_cadastro, status) 
            VALUES (
                    :nome, :login, :senha, :rg, :cpf, :datanascimento, 
                    :email, :logradouro, :numero, :cep, :complemento,
                    :telefone1, :telefone2, :cidade_id, :tipo_cadastro, :status)";
        
        $tipo_cadastro = 1; //1 - ADM, 2 - ALUNO, 3 - PROF
        $status = 1;       // 1 - ATIVO, 0 - INATIVO
        $senha = password_hash($senha, PASSWORD_BCRYPT);


        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":login", $login);
        $consulta->bindParam(":senha", $senha);
        $consulta->bindParam(":rg", $rg);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->bindParam(":datanascimento", $datanascimento);
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
        $sql = "UPDATE pessoa    
                SET nome = :nome,
                    login = :login,
                    senha = :senha,
                    rg = :rg,
                    cpf = :cpf,
                    data_nascimento = :datanascimento, 
                    email = :email,
                    logradouro = :logradouro,
                    numero = :numero,
                    cep = :cep,
                    complemento = :complemento,
                    telefone1 = :telefone1,
                    telefone2 = :telefone2,
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
        $consulta->bindParam(":datanascimento", $datanascimento);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":logradouro", $logradouro);
        $consulta->bindParam(":numero", $numero);
        $consulta->bindParam(":cep", $cep);
        $consulta->bindParam(":complemento", $complemento);
        $consulta->bindParam(":telefone1", $telefone1);
        $consulta->bindParam(":telefone2", $telefone2);
        $consulta->bindParam(":cidade_id", $cidade_id);
        $consulta->bindParam(":id", $id);
    }

    //executar SQL depois de ver qual ele vai passar
    if ($consulta->execute()) {

            //gravar no DB se tudo estiver OK
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/admin';</script>;";
            exit;
        
    }
    echo $consulta->errorInfo()[2];
    exit;
}
// Mensagem de erro
// Javascript - mensagem alert
// Retornar history.back()
echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
