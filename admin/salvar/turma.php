<?php
// Verificar se não está logado
// if (!isset($_SESSION['facilita_escola']['id'])) {
//     exit;
// }

// Verificar se existem dados no POST
if ($_POST) {
    include "../config/conexao.php";
    include "functions.php";

    $id = $serie = $descricao = $ano = $periodo_id = "";

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }
    $periodo_id = getPeriodo($periodo_id);
    if (empty($serie)) {
        echo "<script>alert('Preencha a Série');history.back();</script>";
        exit;
    } else if (empty($descricao)) {
        echo "<script>alert('Preencha a Descrição');history.back();</script>";
        exit;
    } else if (empty($periodo_id) || ($periodo_id == null)) {
        echo "<script>alert('Selecione o Período');history.back();</script>";
        exit;
    } else if (empty($ano)) {
        echo "<script>alert('Preencha o Ano');history.back();</script>";
        exit;
    }

    $sql = "SELECT id 
            FROM turma
            WHERE serie = :serie 
                AND descricao = :descricao 
                AND ano = :ano 
                AND periodo_id = :periodo_id
                AND id <> :id
            LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":serie", $serie);
    $consulta->bindParam(":descricao", $descricao);
    $consulta->bindParam(":ano", $ano);
    $consulta->bindParam(":periodo_id", $periodo_id);
    $consulta->bindParam("id", $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    if (!empty($dados->id)) {
        echo "<script>alert('Registro duplicado');history.back();</script>";
        exit;
    } else {

        //iniciar uma transação com o DB toda alteração pra baixo, só será feito após o commit
        $pdo->beginTransaction();

        if (empty($id)) {
            $status = 1;       // 1 - ATIVO, 0 - INATIVO - Ativo como padrão
            $sql = "INSERT INTO turma
                    (serie, descricao, ano, periodo_id, status)
                VALUES 
                    (:serie, :descricao, :ano, :periodo_id, :status)";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":serie", $serie);
            $consulta->bindParam(":descricao", $descricao);
            $consulta->bindParam(":ano", $ano);
            $consulta->bindParam(":periodo_id", $periodo_id);
            $consulta->bindParam(":status", $status);
        } else {
            $sql = "UPDATE turma    
                SET serie = :serie,
                    descricao = :descricao,
                    ano = :ano,
                    periodo_id = :periodo_id
                WHERE id = :id 
                LIMIT 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":serie", $serie);
            $consulta->bindParam(":descricao", $descricao);
            $consulta->bindParam(":ano", $ano);
            $consulta->bindParam(":periodo_id", $periodo_id);
            $consulta->bindParam(":id", $id);
        }

        //executar SQL depois de ver qual ele vai passar
        if ($consulta->execute()) {

            //gravar no DB se tudo estiver OK
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/turma';</script>;";
            exit;
        }
        echo $consulta->errorInfo()[2];
        exit;
    }
}
// Mensagem de erro
// Javascript - mensagem alert
// Retornar history.back()
echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
