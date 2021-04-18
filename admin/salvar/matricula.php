<?php
if (!isset($_SESSION['facilita_escola']['id'])) {
    exit;
}

// Verificar se existem dados no POST
if ($_POST) {
    include "../config/conexao.php";
    include "functions.php";

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if (empty($matricula)) {
        echo "<script>alert('Preencha a Matricula');history.back();</script>";
        exit;
    } else if (empty($data_matricula)) {
        echo "<script>alert('Preencha a data de matricula');history.back();</script>";
        exit;
    }
    //iniciar uma transação com o DB toda alteração pra baixo, só será feito após o commit
    $pdo->beginTransaction();

    $periodo_id = getPeriodo($periodo_id);

    if (empty($id)) {
        $sql = "INSERT INTO matricula
                    (pessoa_id, data_matricula, matricula)
                VALUES
                    (:pessoa_id, :data_matricula, :matricula)
                    
                INSERT INTO turma_matricula
                    (turma_id, matricula_id)
                VALUES 
                    (:turma_id, :matricula_id)";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":pessoa_id", $pessoa_id);
        $consulta->bindParam(":data_matricula", $data_matricula);
        $consulta->bindParam(":matricula", $matricula);
        $consulta->bindParam(":turma_id", $turma_id);
        $consulta->bindParam(":matricula_id", $matricula_id);
    } else {
        $sql = "UPDATE matricula    
                    SET pessoa_id = :pessoa_id,
                        matricula_id = :matricula_id,
                    WHERE id = :id 
                    LIMIT 1
        
                UPDATE turma_matricula    
                    SET turma_id = :turma_id,
                        turma_id = :turma_id,
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
