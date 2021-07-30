<?php

function apagaImagem($arquivo)
{
	$pasta = "../atividades/";
	$caminho =  $pasta . $arquivo;
	unlink($caminho);
}

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

function getExtensao($nomeArquivo)
{
	$nomeArquivo = explode(".", $nomeArquivo);
	return $nomeArquivo;
}

function getTurmaId($turma_id)
{
	$turma_id = explode("-", $turma_id);
	return $turma_id[0];
}

function getTurma($turma_id)
{
	$turma_id = explode("-", $turma_id);
	return $turma_id[1];
}

function getProfessorId($professor_id)
{
	$professor_id = explode("-", $professor_id);
	return $professor_id[0];
}

function getProfessor($professor_id)
{
	$professor_id = explode("-", $professor_id);
	return $professor_id[1];
}

function getNomeMes($mes)
{
	switch ($mes) {
		case $mes == 1;
			$nomeMes = "Janeiro";
			break;
		case $mes == 2;
			$nomeMes = "Fevereiro";
			break;
		case $mes == 3;
			$nomeMes = "Março";
			break;
		case $mes == 4;
			$nomeMes = "Abril";
			break;
		case $mes == 5;
			$nomeMes = "Maio";
			break;
		case $mes == 6;
			$nomeMes = "Junho";
			break;
		case $mes == 7;
			$nomeMes = "Julho";
			break;
		case $mes == 8;
			$nomeMes = "Agosto";
			break;
		case $mes == 9;
			$nomeMes = "Setembro";
			break;
		case $mes == 10;
			$nomeMes = "Outubro";
			break;
		case $mes == 11;
			$nomeMes = "Novembro";
			break;
		case $mes == 12;
			$nomeMes = "Dezembro";
			break;
	}

	return $nomeMes;
}

function validaCPF($cpf)
{
	$cpf = preg_replace('/[^0-9]/is', '', $cpf);

	if (strlen($cpf) != 11) {
		return "O CPF precisa ter ao menos 11 números";
	}
	if (preg_match('/(\d)\1{10}/', $cpf)) {
		return "CPF inválido";
	}
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

	unlink($imagem);
}
