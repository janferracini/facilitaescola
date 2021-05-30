<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

//verificar se id está vazia
if (empty($id)) {
    echo "<script>
                alert('Não foi possível excluir o registro');history.back();
            </script>";
    exit;
}

$sql = "DELETE FROM recado WHERE id = :id limit 1";
$consulta = $pdo->prepare($sql);
$consulta->bindParam(":id", $id);
//verificar se não executou
if (!$consulta->execute()) {
    echo "<script>
            alert('Erro ao excluir');javascript:history.back();
        </script>";
}
echo "<script>alert('Registro excluído');location.href='listar/recado'</script>";
