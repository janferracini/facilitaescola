<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}

//verificar se id está vazia
if (empty($id)) {
    echo "<script>
                alert('Não foi possível concluir a solicitação');history.back();
            </script>";
    exit;
}

$sql = "DELETE FROM atividade WHERE id = ? limit 1";
$consulta = $pdo->prepare($sql);
$consulta->bindParam(1, $id);
//verificar se não executou
if (!$consulta->execute()) {

    //consulta erros - sempre depois do execute
    //echo $consulta->errorInfo()[2];

    echo "<script> alert('Erro ao excluir');javascript:history.back();</script>";
}

echo "<script>alert('Registro excluído');location.href='listar/atividade'</script>";
