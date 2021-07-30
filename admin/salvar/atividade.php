<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página, faça login novamente para continuar');location.href='sair.php'</script>";
    exit;
}

if ($_POST) {
    include "../config/conexao.php";
    include "functions.php";

    $id = $atividade = $arquivo = $data_postagem = $grade_id  = "";
    $grade_id = "";

    foreach ($_POST as $key => $value) {
        $$key = trim(strip_tags($value));
    }

    if (empty($atividade)) {
        echo "<script>alert('Preencha a Atividade');history.back();</script>";
        exit;
    }

    if (empty($grade_id)) {
        echo "<script>alert('Preencha a Grade');history.back();</script>";
        exit;
    }

    $pdo->beginTransaction();
    $nomeArquivo = $_FILES["arquivo"]["name"];
    $getExtensao = getExtensao($nomeArquivo);
    $extensao = end($getExtensao);
    $arquivo = time() . "-" . $_SESSION["facilita_escola"]["nome"] . "." . $extensao;
    $pasta = "../atividades/";

    $extencoes = ['jpg', 'jpeg', 'doc', 'docx', 'odt', 'pdf'];
    if (!in_array($extensao, $extencoes) === true) {
        echo "<script>alert('Selecione um arquivo válido. Caso necessite, exporte seu documento no formato PDF antes de fazer o envio.');history.back();</script>";
        exit;
    }

    if (empty($id)) {
        $sql = "INSERT INTO atividade
                    (atividade, arquivo, grade_id)
                VALUES 
                    (:atividade, :arquivo, :grade_id)";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":atividade", $atividade);
        $consulta->bindParam(":arquivo", $arquivo);
        $consulta->bindParam(":grade_id", $grade_id);
    } else {
        $sql = "UPDATE atividade
                SET atividade = :atividade, arquivo = :arquivo, grade_id = :grade_id
                WHERE id = :id
                LIMIT 1";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->bindParam(":atividade", $atividade);
        $consulta->bindParam(":arquivo", $arquivo);
        $consulta->bindParam(":grade_id", $grade_id);
    }

    if ($consulta->execute()) {

        if ((empty($_FILES["arquivo"]["type"])) and (!empty($id))) {
            $pdo->commit();
            echo '<script>alert("Registro salvo");location.href="listar/atividade";</script>;';
            exit;
        }

        $tamanho   = $_FILES['arquivo']['size'];
        if ($tamanho >= 3145728) {
            echo '<script>alert("Arquivo exede o tamanho suportado");history.back();</script>';
            exit;
        }

        if (move_uploaded_file($_FILES["arquivo"]["tmp_name"], $pasta . $arquivo)) {
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/atividade';</script>";
            exit;
        }
    }
    echo $consulta->errorInfo()[2];
    echo print_r($_POST);
    echo print_r($_FILES);
    exit;
}

echo "<p class='alert alert-danger'>Erro ao realizar requisição.</p>";
