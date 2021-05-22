<?php

function getPeriodo($periodo_id)
{
	$periodo_id = explode("-", $periodo_id);
	return $periodo_id[1];
}
function getGradeId($grade_id)
{
	$grade_id = explode('-', $grade_id);
	return $grade_id[0];
}

function validaCPF($cpf)
{
	// Extrai somente os números
	$cpf = preg_replace('/[^0-9]/is', '', $cpf);

	// Verifica se foi informado todos os digitos corretamente
	if (strlen($cpf) != 11) {
		return "O CPF precisa ter ao menos 11 números";
	}
	// Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
	if (preg_match('/(\d)\1{10}/', $cpf)) {
		return "CPF inválido";
	}
	// Faz o calculo para validar o CPF
	for ($t = 9; $t < 11; $t++) {
		for ($d = 0, $c = 0; $c < $t; $c++) {
			$d += $cpf[$c] * (($t + 1) - $c);
		}
		$d = ((10 * $d) % 11) % 10;
		if ($cpf[$c] != $d) {
			return "CPF inválido";
		}
	}
	return true;
}

function formatarDN($data_nascimento)
{
	// 20/12/2020 -> 2020-12-20
	$data_nascimento = explode("/", $data_nascimento);
	return $data_nascimento = $data_nascimento[2] . "-" . $data_nascimento[1] . "-" . $data_nascimento[0];
}

function fotoUsuario($pastaFotos, $imagem, $nome)
{
	$imagem = $pastaFotos . $imagem;

	list($largura1, $altura1) = getimagesize($imagem);

	$largura = 640;
	$percent = ($largura / $largura1);
	$altura = $altura1 * $percent;

	$imagem_gerada = $pastaFotos . $nome . ".jpg";
	$path = $imagem;
	$imagem_orig = ImageCreateFromJPEG($path);
	$pontoX = ImagesX($imagem_orig);
	$pontoY = ImagesY($imagem_orig);
	$imagem_fin = ImageCreateTrueColor($largura, $altura);
	ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $largura + 1, $altura + 1, $pontoX, $pontoY);
	ImageJPEG($imagem_fin, $imagem_gerada, 100);
	ImageDestroy($imagem_orig);
	ImageDestroy($imagem_fin);

	//apagar a imagem antiga
	unlink($imagem);
}
