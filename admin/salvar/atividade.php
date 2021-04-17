<?php
// Verificar se não está logado
// if (!isset($_SESSION['facilita_escola']['id'])) {
//     exit;
// }

// Verificar se existem dados no POST
if ($_POST) {
    include "../config/conexao.php";

    $id = $atividade = "";

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if (empty($atividade)) {
        echo "<script>alert('Preencha a Atividade');history.back();</script>";
        exit;
    }

    //executar SQL depois de ver qual ele vai passar
    if ($consulta->execute()) {

        //gravar no DB se tudo estiver OK
        $pdo->commit();
        echo "<script>alert('Registro salvo');location.href='listar/atividade';</script>;";
        exit;
    }
    echo $consulta->errorInfo()[2];
    exit;
}
// Mensagem de erro
// Javascript - mensagem alert
// Retornar history.back()
echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
