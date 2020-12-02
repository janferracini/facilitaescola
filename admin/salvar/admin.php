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
                    nome, login, senha, rg, cpf, datanascimento, 
                    data_cadastro, email, logradouro, numero, cep, complemento,
                    telefone1, telefone2, foto, status, cidade_id, tipo_cadastro) 
            VALUES (
                    :nome, :login, :senha, :rg, :cpf, :datanascimento, 
                    :data_cadastro, :email, :logradouro, :numero, :cep, :complemento,
                    :telefone1, :telefone2, :foto, :status, :cidade_id, :tipo_cadastro)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":login", $login);
        $consulta->bindParam(":senha", $senha);
        $consulta->bindParam(":rg", $rg);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->bindParam(":datanascimento", $datanascimento);
        $consulta->bindParam(":data_cadastro", $data_cadastro);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":logradouro", $logradouro);
        $consulta->bindParam(":numero", $numero);
        $consulta->bindParam(":cep", $cep);
        $consulta->bindParam(":complemento", $complemento);
        $consulta->bindParam(":telefone1", $telefone1);
        $consulta->bindParam(":telefone2", $telefone2);
        $consulta->bindParam(":foto", $foto);
        $consulta->bindParam(":status", $status);
        $consulta->bindParam(":cidade_id", $cidade_id);
        $consulta->bindParam(":tipo_cadastro", 1);

    } else {
        $sql = "UPDATE pessoa    
                SET nome = :nome,
                    login = :login,
                    senha = :senha,
                    rg = :rg,
                    cpf = :cpf,
                    datanascimento = :datanascimento, 
                    data_cadastro = :data_cadastro,
                    email = :email,
                    logradouro = :logradouro,
                    numero = :numero,
                    cep = :cep,
                    complemento = :complemento,
                    telefone1 = :telefone1,
                    telefone2 = :telefone2,
                    foto = :foto,
                    status = :status,
                    cidade_id = :cidade_id)
                WHERE id = :id 
                LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":login", $login);
        $consulta->bindParam(":senha", $senha);
        $consulta->bindParam(":rg", $rg);
        $consulta->bindParam(":cpf", $cpf);
        $consulta->bindParam(":datanascimento", $datanascimento);
        $consulta->bindParam(":data_cadastro", $data_cadastro);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":logradouro", $logradouro);
        $consulta->bindParam(":numero", $numero);
        $consulta->bindParam(":cep", $cep);
        $consulta->bindParam(":complemento", $complemento);
        $consulta->bindParam(":telefone1", $telefone1);
        $consulta->bindParam(":telefone2", $telefone2);
        $consulta->bindParam(":foto", $foto);
        $consulta->bindParam(":status", $status);
        $consulta->bindParam(":cidade_id", $cidade_id);
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
