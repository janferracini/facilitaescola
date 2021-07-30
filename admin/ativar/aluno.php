<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}

$sql = "UPDATE pessoa
        SET status = 1
        WHERE id = :id
        LIMIT 1";
$consulta = $pdo->prepare($sql);
$consulta->bindParam(":id", $id);

if (!$consulta->execute()) {
    echo "<script>alert('Erro ao ativar');javascript:history.back();</script>";
}

echo "<script>alert('Cadastro ativado');location.href='inativo/aluno'</script>";
