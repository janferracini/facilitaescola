<?php
if (!isset($_SESSION["facilita_escola"]["id"])) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}

if ($_SESSION["facilita_escola"]["tipo_cadastro"] != 1) {
    echo "<script>alert('Erro na requisição da página');location.href='javascript:history.back()'</script>";
    exit;
}

// Verificar se existem dados no POST
if ($_POST) {
    include "../config/conexao.php";

    $id = $atividade = $arquivo = $data_postagem = $grade_id  = "";
    // tabela grade
    $grade_id = "";


    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if (empty($atividade)) {
        echo "<script>alert('Preencha a Atividade');history.back();</script>";
        exit;
    }

    if (empty($grade_id)) {
        echo "<script>alert('Preencha a Atividade');history.back();</script>";
        exit;
    }

    // $tipo = strrchr(".", $_FILES['arquivo']['type']);
    // $extencoes = ['image/jpeg', 'application/msword', 'application/pdf', 'application/vnd.oasis.opendocument.text'];
    // if (in_array($tipo, $extencoes) === true) {
    //     echo "<script>alert('Selecione um arquivo válido');</script>";
    //     echo print_r($_FILES);
    //     exit;
    // }

    $pdo->beginTransaction();
    //salva a hora da máquina + a id de quem está na sessão como nome do arquivo
    $extensao = substr($_FILES["arquivo"]["name"], -4, 5);
    $arquivo = time() . "-" . $_SESSION["facilita_escola"]["nome"] . "" . $extensao;
    $pasta = "../atividades/";

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
    // Executar e verificar se deu certo
    if ($consulta->execute()) {

        //verifica se o arquivo não está sendo enviado 
        //arquivo deve estar vazio e id não pode estar vazio - editando
        if ((empty($_FILES["arquivo"]["type"])) and (!empty($id))) {
            $pdo->commit();
            echo '<script>alert("Registro salvo");location.href="listar/atividade";</script>;';
            exit;
        }

        // $tamanho   = $_FILES['arquivo']['size'];
        // if ($tamanho <= 3145728) {
        //     echo "<script>alert('Arquivo exede o tamanho suportado');history.back();</script>";
        //     exit;
        // }



        //copiar a imagem para a pata de arquivos
        if (move_uploaded_file($_FILES["arquivo"]["tmp_name"], $pasta . $arquivo)) {

            //gravar no DB se tudo estiver OK
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
echo print_r($_FILES);
