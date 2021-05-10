<?php
// Verificar se não está logado
// if (!isset($_SESSION['facilita_escola']['id'])) {
//     exit;
// }

// Verificar se existem dados no POST
if ($_POST) {
    include "../config/conexao.php";

    $id = $descricao = $arquivo = $data_postagem = $grade_id  = "";
    // tabela grade
    $turma_id = "";
    // tabela turma
    $serie = $descricao = $ano = $periodo_id = "";
    // tabela periodo
    $periodo = "";

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if (empty($grade_id)) {
        echo "<script>alert('Selecione a turma');history.back();</script>";
        exit;
    }
    if (empty($atividade)) {
        echo "<script>alert('Preencha a Atividade');history.back();</script>";
        exit;
    }
    if (empty($arquivo)) {
        echo "<script>alert('Selecione o arquivo');history.back();</script>";
        exit;
    }

    $pdo->beginTransaction();

    if (empty($id)) {

        $sql = "INSERT INTO atividade
                        (descricao, arquivo, grade_id)
                    VALUES 
                        (:descricao, :arquivo, :grade_id)";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":descricao", $descricao);
        $consulta->bindParam(":arquivo", $arquivo);
        $consulta->bindParam(":data_postagem", $data_postagem);
        $consulta->bindParam(":grade_id", $grade_id);
    } else {
        $sql = "UPDATE atividade
                SET descricao = :descricao, arquivo = :arquivo, grade_id = :grade_id
                WHERE id = :id
                LIMIT 1";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->bindParam(":descricao", $descricao);
        $consulta->bindParam(":arquivo", $arquivo);
        $consulta->bindParam(":grade_id", $grade_id);
    }
    // Executar e verificar se deu certo
    if ($consulta->execute()) {
        $pdo->commit();
        echo '<script>alert("Registro salvo");location.href="listar/atividade";</script>';
        exit;
    }
    echo $consulta->errorInfo()[2];
    exit;
}

echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
