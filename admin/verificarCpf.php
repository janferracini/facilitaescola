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

if (empty($id)) {
    $sql = "SELECT id FROM pessoa WHERE cpf = :cpf LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":cpf", $cpf);
} else {
    $sql = "SELECT id FROM pessoa WHERE cpf = :cpf AND id <> :id LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":cpf", $cpf);
    $consulta->bindParam(":id", $id);
}
