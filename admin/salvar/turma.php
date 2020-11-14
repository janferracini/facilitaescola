<?php
// Verificar se não está logado
// if (!isset($_SESSION['hqs']['id'])) {
//     exit;
// }

// Verificar se existem dados no POST
if ($_POST) {
    include "../config/conexao.php";
    include "../functions.php";

    $id = $serie = $descricao = $ano = $periodo_id = "";

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if (empty($serie)) {
        echo "<script>alert('Preencha a Série');history.back();</script>";
        exit;
    } else if (empty($descricao)) {
        echo "<script>alert('Preencha a Descrição');history.back();</script>";
        exit;
    } else if (empty($periodo_id)) {
        echo "<script>alert('Selecione o Período');history.back();</script>";
        exit;
    } else if (empty($ano)) {
        echo "<script>alert('Preencha o Ano');history.back();</script>";
        exit;
    }
    //iniciar uma transação com o DB toda alteração pra baixo, só será feito após o commit
    $pdo->beginTransaction();

    $periodo_id = getPeriodo($periodo_id);

    if (empty($id)) {
        $sql = "INSERT INTO turma
                    (serie, descricao, ano, periodo_id)
                VALUES 
                    (:serie, :descricao, :ano, :periodo_id)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":serie", $serie);
        $consulta->bindParam(":descricao", $descricao);
        $consulta->bindParam(":ano", $ano);
        $consulta->bindParam(":periodo_id", $periodo_id);
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
// Mensagem de erro
// Javascript - mensagem alert
// Retornar history.back()
echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
