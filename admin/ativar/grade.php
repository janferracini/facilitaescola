<?php
//verificar se não está logado
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}


$sql = "UPDATE grade
        SET status = 1
        WHERE id = :id
        LIMIT 1";

$consulta = $pdo->prepare($sql);
$consulta->bindParam(":id", $id);

//verificar se não executou
if (!$consulta->execute()) {
    echo "<script>
                alert('Erro ao ativar');javascript:history.back();
            </script>";
}

echo "<script>alert('Cadastro ativado');location.href='inativo/grade'</script>";
