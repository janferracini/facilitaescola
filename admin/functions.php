<?php
/*

GDLIB biblioteca para manipular imagens
	    validaCPF - função para validar CPF
	    Como usar: 
	    $cpf = "123.123.123-34";
	    $msg = validaCPF($cpf);
	    if ( $msg != 1 ) echo $msg; //deu erro
	    retornando 1 o documento é inválido
	*/
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

function validaCNPJ($cnpj)
{
	$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
	// Valida tamanho
	if (strlen($cnpj) != 14)
		return "CNPJ precisa ter ao menos 14 números";
	// Valida primeiro dígito verificador
	for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
		$soma += $cnpj[$i] * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
	if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
		return "CNPJ inválido";
	// Valida segundo dígito verificador
	for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
		$soma += $cnpj[$i] * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
	return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
}

/*
		Função para redimensionar imagens JPG
		Irá criar 3 imagens: 
		- G Largura de 800px 
		- M Largura de 640px
		- P Largura de 250px
		A altura será proporcional a altura para que a imagem não fique deslocada

		Parâmetros: arquivo da imagem (Ex.: fotos/imagem.jpg), novo nome para renomear (Ex.: 12345)
	*/

function redimensionarImagem($pastaFotos, $imagem, $nome)
{

	$imagem = $pastaFotos . $imagem;

	list($largura1, $altura1) = getimagesize($imagem);

	$largura = 800;
	$percent = ($largura / $largura1);
	$altura = $altura1 * $percent;

	$imagem_gerada = $pastaFotos . $nome . "g.jpg";
	$path = $imagem;
	$imagem_orig = ImageCreateFromJPEG($path);
	$pontoX = ImagesX($imagem_orig);
	$pontoY = ImagesY($imagem_orig);
	$imagem_fin = ImageCreateTrueColor($largura, $altura);
	ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $largura + 1, $altura + 1, $pontoX, $pontoY);
	ImageJPEG($imagem_fin, $imagem_gerada, 100);
	ImageDestroy($imagem_orig);
	ImageDestroy($imagem_fin);

	$largura = 640;
	$percent = ($largura / $largura1);
	$altura = $altura1 * $percent;

	$imagem_gerada = $pastaFotos . $nome . "m.jpg";
	$path = $imagem;
	$imagem_orig = ImageCreateFromJPEG($path);
	$pontoX = ImagesX($imagem_orig);
	$pontoY = ImagesY($imagem_orig);
	$imagem_fin = ImageCreateTrueColor($largura, $altura);
	ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $largura + 1, $altura + 1, $pontoX, $pontoY);
	ImageJPEG($imagem_fin, $imagem_gerada, 80);
	ImageDestroy($imagem_orig);
	ImageDestroy($imagem_fin);

	$largura = 250;
	$percent = ($largura / $largura1);
	$altura = $altura1 * $percent;

	$imagem_gerada = $pastaFotos . $nome . "p.jpg";
	$path = $imagem;
	$imagem_orig = ImageCreateFromJPEG($path);
	$pontoX = ImagesX($imagem_orig);
	$pontoY = ImagesY($imagem_orig);
	$imagem_fin = ImageCreateTrueColor($largura, $altura);
	ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $largura + 1, $altura + 1, $pontoX, $pontoY);
	ImageJPEG($imagem_fin, $imagem_gerada, 80);
	ImageDestroy($imagem_orig);
	ImageDestroy($imagem_fin);

	//apagar a imagem antiga
	unlink($imagem);
}

//função para formatar a $editora
function getEditora($editora_id)
{
	// Editora - ID -> ID
	$editora_id = explode("-", $editora_id);
	return $editora_id[1];
}

function getTipo($tipo_id)
{
	// Editora - ID -> ID
	$tipo_id = explode("-", $tipo_id);
	return $tipo_id[1];
}

function formatar($data)
{
	// 20/12/2020 -> 2020/12/20
	$data = explode("/", $data);
	return $data[2] . "-" . $data[1] . "-" . $data[0];
}

function formatarDN($datanascimento)
{
	// 20/12/2020 -> 2020/12/20
	$datanascimento = explode("/", $datanascimento);
	return $datanascimento[2] . "-" . $datanascimento[1] . "-" . $datanascimento[0];
}

//formatar valor
//12.000,00 -> 120000.00
function formatarValor($valor)
{
	$valor = str_replace(".", "", $valor);  // -> 12000,00
	return str_replace(",", ".", $valor); // -> 12000.00
}

//função para retirar os __ do numero
function retirar($texto)
{
	//12__ -> 12
	return str_replace("_", "", $texto);
	//o que substituir, pelo que substiquir, quem substituir
}

function fotoCliente($pastaFotos, $imagem, $nome)
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
