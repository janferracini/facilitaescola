<?php
session_start();

if (!isset($_SESSION["facilita_escola"]["id"])) {
    exit;
}
$cpf = $_GET['cpf'] ?? "";
$id = $_GET['id'] ?? "";

include "config/conexao.php";
include "functions.php";

$msg = validaCPF($cpf);
if ($msg != 1) {
    echo $msg;
    exit;
}

//verificar se cpf já existe = ningém pode ter esse CPF 
if (empty($id)) {
    //inserindo - não pode exixtir
    $sql = "SELECT id FROM pessoa WHERE cpf = :cpf LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":cpf", $cpf);
} else {
    //atualizando- apenas essa id pode ter esse cpf
    $sql = "SELECT id FROM pessoa WHERE cpf = :cpf AND id <> :id LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":cpf", $cpf);
    $consulta->bindParam(":id", $id);
}
