<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 2) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}
// Verificar se existem dados no POST
if ($_POST) {
    include "../config/conexao.php";

    $id = $titulo = $mensagem = "";
    $aluno = $_SESSION["facilita_escola"]["id"];

    $sql = "SELECT  m.*, m.id mid 
        FROM matricula m
        INNER JOIN pessoa p ON ( p.id = m.pessoa_id)
        WHERE p.id = $aluno
        LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $matricula_id = $dados->mid;


    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }
    if (empty($titulo)) {
        echo "<script>alert('Preencha o Titulo');history.back();</script>";
        exit;
    }
    if (empty($mensagem)) {
        echo "<script>alert('Preencha a Mensagem');history.back();</script>";
        exit;
    }
    $pdo->beginTransaction();

    $sql = "INSERT INTO mensagem
                    (titulo, mensagem, matricula_id)
                VALUES 
                    (:titulo, :mensagem, :matricula_id)";

    $matricula_id = $matricula_id;

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":titulo", $titulo);
    $consulta->bindParam(":mensagem", $mensagem);
    $consulta->bindParam(":matricula_id", $matricula_id);

    if ($consulta->execute()) {
        $pdo->commit();
        echo "<script>alert('Registro salvo');location.href='listar/mensagem';</script>";
    } else {
        echo '<script>alert("Erro ao salvar");</script>';
        exit;
        // exit;
    }
}
echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
