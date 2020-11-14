<?php
// Verificar se não está logado
// if (!isset($_SESSION['hqs']['id'])) {
//     exit;
// }

// Verificar se existem dados no POST
if ($_POST) {
    include "../config/conexao.php";

    $id = $disciplina = "";

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if (empty($disciplina)) {
        echo "<script>alert('Preencha a Série');history.back();</script>";
        exit;
    }
    //iniciar uma transação com o DB toda alteração pra baixo, só será feito após o commit
    $pdo->beginTransaction();

    if (empty($id)) {
        $sql = "INSERT INTO disciplina
                    (disciplina)
                VALUES 
                    (:disciplina)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":disciplina", $disciplina);

    } else {
        $sql = "UPDATE disciplina    
                SET disciplina = :disciplina
                WHERE id = :id 
                LIMIT 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":disciplina", $disciplina);
        $consulta->bindParam(":id", $id);
    }

    //executar SQL depois de ver qual ele vai passar
    if ($consulta->execute()) {

            //gravar no DB se tudo estiver OK
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/disciplina';</script>;";
            exit;
        
    }
    echo $consulta->errorInfo()[2];
    exit;
}
// Mensagem de erro
// Javascript - mensagem alert
// Retornar history.back()
echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";