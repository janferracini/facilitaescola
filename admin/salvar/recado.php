<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}
// Verificar se existem dados no POST
if ($_POST) {
    include "../config/conexao.php";

    $id = $titulo = $conteudo = $data_postagem = $turma_id = "";

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if (empty($titulo)) {
        echo "<script>alert('Preencha o Título');history.back();</script>";
        exit;
    }

    if (empty($conteudo)) {
        echo "<script>alert('Preencha o Conteúdo');history.back();</script>";
        exit;
    }

    if (empty($turma_id)) {
        echo "<script>alert('Selecione a Turma');history.back();</script>";
        exit;
    }

    $pdo->beginTransaction();

    if (empty($id)) {

        $sql = "INSERT INTO recado
                        (titulo, conteudo, turma_id)
                    VALUES 
                        (:titulo, :conteudo, :turma_id)";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":titulo", $titulo);
        $consulta->bindParam(":conteudo", $conteudo);
        $consulta->bindParam(":turma_id", $turma_id);
    } else {
        $sql = "UPDATE recado
            SET titulo = :titulo, conteudo = :conteudo, turma_id = :turma_id
            WHERE id = :id
            LIMIT 1";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->bindParam(":titulo", $titulo);
        $consulta->bindParam(":conteudo", $conteudo);
        $consulta->bindParam(":turma_id", $turma_id);
    }
    // Executar e verificar se deu certo
    if ($consulta->execute()) {
        $pdo->commit();
        echo '<script>alert("Registro salvo");location.href="listar/recado";</script>';
        exit;
    }
    echo $consulta->errorInfo()[2];
    exit;
}

echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
