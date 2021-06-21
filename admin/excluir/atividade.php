<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}
include('functions.php');

$sql = "SELECT arquivo FROM atividade WHERE id = $id";
$consulta = $pdo->prepare($sql);
$consulta->bindParam(":id", $id);
$consulta->execute();
$dados = $consulta->fetch(PDO::FETCH_OBJ);

$arquivo = $dados->arquivo;

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

if (!$consulta->execute()) {
    echo "<script> alert('Erro ao excluir');javascript:history.back();</script>";
}

echo "<script>alert('Registro excluído');location.href='listar/atividade'</script>";
apagaImagem($arquivo);
