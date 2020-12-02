<?php
	//incluir o arquivo da funcao
	include "functions.php";

	$cpf = "";
	if ( isset ( $_GET["cpf"] ) )
		$cpf = trim ( $_GET["cpf"] );

	//verificar se o cpf esta em branco
	if ( empty ( $cpf ) ) {
		echo "Forneça um CPF";
		exit;
	} else if ( $cpf == "123.456.789-09" ) {
		echo "CPF inválido";
		exit;
	}

	//executar a função
	echo validaCPF($cpf);