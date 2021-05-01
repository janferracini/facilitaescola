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
    $pdo->beginTransaction();

    if (empty($id)) {
        $sql = "INSERT INTO grade (turma_id, disciplina_id, professor_id)
                VALUES (:turma_id, :disciplina_id, :professor_id)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":turma_id", $turma_id);
        $consulta->bindParam(":disciplina_id", $disciplina_id);
        $consulta->bindParam(":professor_id", $professor_id);
    } else {
        $sql = "UPDATE grade
                SET turma_id = :turma_id,
                    disciplina_id = :disciplina_id,
                    professor_id = :professor_id
                WHERE id = :id
                LIMIT 1";
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

echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
