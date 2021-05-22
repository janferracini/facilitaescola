<?php
session_start();
require_once __DIR__ . '../../vendor/autoload.php';
date_default_timezone_set('America/Sao_Paulo');
$stylesheet = file_get_contents('../../dist/css/css-pdf.css');
$nome = $_SESSION['facilita_escola']['nome'];
require("gerar_aluno_turma.php");


$html = '';


$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html);
$mpdf->Output("meu-pdf", "I");
