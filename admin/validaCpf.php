<?php

include "functions.php";

$cpf = "";
if (isset($_GET["cpf"]))
	$cpf = trim($_GET["cpf"]);

if ($cpf == "123.456.789-09") {
	echo "CPF inválido";
	exit;
}

echo validaCPF($cpf);
