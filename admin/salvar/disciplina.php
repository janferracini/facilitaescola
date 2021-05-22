<?php
// Verificar se não está logado
// if (!isset($_SESSION['facilita_escola']['id'])) {
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
        echo "<script>alert('Preencha a Disciplina');history.back();</script>";
        exit;
    }

    // verificar se existe disciplina de mesmo nome
    $sql = "SELECT id
            FROM disciplina
            WHERE disciplina = :disciplina AND id <> :id
            LIMIT 1 ";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":disciplina", $disciplina);
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (!empty($dados->id)) {
        echo "<script>alert('Disciplina já existente');location.href='listar/disciplina';</script>;";
        exit;
    }

    $pdo->beginTransaction();

    if (empty($id)) {
        $status = 1;       // 1 - ATIVO, 0 - INATIVO - Ativo como padrão
        $sql = "INSERT INTO disciplina (disciplina, status)
                VALUES (:disciplina, :status)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":disciplina", $disciplina);
        $consulta->bindParam(":status", $status);
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
