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
    include "../config/conexao.php";

    $id = $disciplina = "";

    foreach ($_POST as $key => $value) {
        $$key = trim(strip_tags($value));
    }

    if (empty($disciplina)) {
        echo "<script>alert('Preencha a Disciplina');history.back();</script>";
        exit;
    }

    $sql = "SELECT id
            FROM disciplina
            WHERE disciplina = :disciplina AND id <> :id
            LIMIT 1 ";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":disciplina", $disciplina);
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (!empty($dados->id)) {
        echo "<script>alert('Disciplina já existente');location.href='listar/disciplina';</script>;";
        exit;
    }

    $pdo->beginTransaction();

    if (empty($id)) {
        $status = 1;
        $sql = "INSERT INTO disciplina (disciplina, status)
                VALUES (:disciplina, :status)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":disciplina", $disciplina);
        $consulta->bindParam(":status", $status);
    } else {
        $sql = "UPDATE disciplina    
                SET disciplina = :disciplina
                WHERE id = :id 
                LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":disciplina", $disciplina);
        $consulta->bindParam(":id", $id);
    }

    if ($consulta->execute()) {
        $pdo->commit();
        echo "<script>alert('Registro salvo');location.href='listar/disciplina';</script>;";
        exit;
    }
    echo $consulta->errorInfo()[2];
    exit;
}

echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
