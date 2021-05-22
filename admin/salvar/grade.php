<?php

if ($_POST) {
    include "../config/conexao.php";
    include "functions.php";

    $turma_id = $disciplina_id = $professor_id = "";

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if (empty($turma_id)) {
        echo "O campo Turma deve ser preenchido";
    }
    if (empty($disciplina_id)) {
        echo "O campo Disciplina deve ser preenchido";
    }
    if (empty($professor_id)) {
        echo "O campo Professor deve ser preenchido";
    }

    $sql = "SELECT id 
            FROM grade
            WHERE turma_id = :turma_id 
                AND disciplina_id = :disciplina_id 
                AND professor_id = :professor_id 
                AND id <> :id
            LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":turma_id", $turma_id);
    $consulta->bindParam(":disciplina_id", $disciplina_id);
    $consulta->bindParam(":professor_id", $professor_id);
    $consulta->bindParam("id", $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    if (!empty($dados->id)) {
        echo "<script>alert('Registro duplicado');history.back();</script>";
        exit;
    } else {

        $pdo->beginTransaction();
        if (empty($id)) {
            $status = 1;       // 1 - ATIVO, 0 - INATIVO - Ativo como padrão
            $sql = "INSERT INTO grade (turma_id, disciplina_id, professor_id, status)
                    VALUES (:turma_id, :disciplina_id, :professor_id, :status)";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":turma_id", $turma_id);
            $consulta->bindParam(":disciplina_id", $disciplina_id);
            $consulta->bindParam(":professor_id", $professor_id);
            $consulta->bindParam(":status", $status);
        } else {
            $sql = "UPDATE grade
                    SET turma_id = :turma_id,
                        disciplina_id = :disciplina_id,
                        professor_id = :professor_id
                    WHERE id = :id";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":turma_id", $turma_id);
            $consulta->bindParam(":disciplina_id", $disciplina_id);
            $consulta->bindParam(":professor_id", $professor_id);
            $consulta->bindParam(":id", $id);
        }

        if ($consulta->execute()) {
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/grade';</script>;";
            exit;
        }
        echo $consulta->errorInfo()[2];
        exit;
    }
}

echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
