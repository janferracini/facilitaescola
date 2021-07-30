<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

$sql = "UPDATE pessoa
        SET status = 0
        WHERE id = :id
        LIMIT 1";

$consulta = $pdo->prepare($sql);
$consulta->bindParam(":id", $id);
if (!$consulta->execute()) {
    echo "<script>alert('Erro ao inativar');javascript:history.back();</script>";
}

echo "<script>alert('Registro inativado');location.href='listar/admin'</script>";
