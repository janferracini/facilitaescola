<?php
//verificar se não está logado
if (!isset($_SESSION["facilita_escola"]["id"])) {
    exit;
}

//verificar se id está vazia
if (empty($id)) {
    echo "<script>
                alert('Não foi possível excluir o registro');history.back();
            </script>";
    exit;
}

//verificar se existe uma grade cadastrada com essa disciplina
$sql = "SELECT r.id rid, r.*, g.id gid, g.turma_id tid, 
            t.*
            FROM recado r
            INNER JOIN turma t ON (t.id = g.turma_id) 
            INNER JOIN grade g ON (g.id = r.grade_id) 
            WHERE r.id = :id
            LIMIT 1";
//prepara a sql para executar
$consulta = $pdo->prepare($sql);
//passar o id do parametro
$consulta->bindParam(":id", $id);
//executa o sql
$consulta->execute();
//recuperar os dados selecionados
$dados = $consulta->fetch(PDO::FETCH_OBJ);
//se existir  avisar e voltar
if (!empty($dados->id)) {
    //se o id não está vazio, não posso excluir

    echo "<script>
                            alert('Não é possível excluir este registro 
                                pois existe uma grade relacionada.');history.back();
                        </script>";

    //INATIVAR ITEM
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