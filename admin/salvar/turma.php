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
    include "functions.php";

    $id = $serie = $descricao = $ano = $periodo_id = "";

    foreach ($_POST as $key => $value) {
        $$key = trim(strip_tags($value));
    }

    $periodo_id = getPeriodo($periodo_id);

    if (empty($serie)) {
        echo "<script>alert('Preencha a Série');history.back();</script>";
        exit;
    } else if (empty($descricao)) {
        echo "<script>alert('Preencha a Descrição');history.back();</script>";
        exit;
    } else if (empty($periodo_id) || ($periodo_id == null)) {
        echo "<script>alert('Selecione o Período');history.back();</script>";
        exit;
    } else if (empty($ano)) {
        echo "<script>alert('Preencha o Ano');history.back();</script>";
        exit;
    }

    $sql = "SELECT id 
            FROM turma
            WHERE serie = :serie 
                AND descricao = :descricao 
                AND ano = :ano 
                AND periodo_id = :periodo_id
                AND id <> :id
            LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":serie", $serie);
    $consulta->bindParam(":descricao", $descricao);
    $consulta->bindParam(":ano", $ano);
    $consulta->bindParam(":periodo_id", $periodo_id);
    $consulta->bindParam("id", $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    if (!empty($dados->id)) {
        echo "<script>alert('Registro duplicado');history.back();</script>";
        exit;
    } else {
        $pdo->beginTransaction();

        if (empty($id)) {
            $sql = "INSERT INTO turma
                    (serie, descricao, ano, periodo_id, status)
                VALUES 
                    (:serie, :descricao, :ano, :periodo_id, :status)";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":serie", $serie);
            $consulta->bindParam(":descricao", $descricao);
            $consulta->bindParam(":ano", $ano);
            $consulta->bindParam(":periodo_id", $periodo_id);
            $consulta->bindParam(":status", $status);
        } else {
            $sql = "UPDATE turma    
                SET serie = :serie,
                    descricao = :descricao,
                    ano = :ano,
                    periodo_id = :periodo_id
                WHERE id = :id 
                LIMIT 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":serie", $serie);
            $consulta->bindParam(":descricao", $descricao);
            $consulta->bindParam(":ano", $ano);
            $consulta->bindParam(":periodo_id", $periodo_id);
            $consulta->bindParam(":id", $id);
        }

        if ($consulta->execute()) {

            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/turma';</script>;";
            exit;
        }
        echo $consulta->errorInfo()[2];
        exit;
    }
}
echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
