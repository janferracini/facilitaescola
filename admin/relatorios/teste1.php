<?php
session_start();
require_once __DIR__ . '../../vendor/autoload.php';
date_default_timezone_set('America/Sao_Paulo');
$stylesheet = file_get_contents('../../dist/css/css-pdf.css');
$nome = $_SESSION['facilita_escola']['nome'];
require("gerar_aluno_turma.php");


$html = '<body style="font-family: Verdana, Tahoma, Geneva, sans-serif;">
<table>
    <tr>
        <td>
            <img src="../img/FE-logo.png" class="imagemlogo" />
        </td>
        <td>
            <p class="cabecalho">Facilita Escola</p>
            <p>Gestão escolar de qualidade</p>
        </td>
    </tr>
</table>
<div class="container">
    <h2>Relatório de Alunor por Turma</h2>
    <p class="data float-right">Gedado em ' . date("d/m/Y H:i") . ', por ' . $nome . ' </p>
    <table>
    <thead>
    <tr>
        <th>Aluno</th>
        <th style="width: 25%;">Matrícula</th>
        <th style="width: 25%;">Professor</th>
        <th style="width: 20%;">Ações</th>
    </tr>
</thead>
        <tr>';
$html .= $resultado;
$html .= '</tr>
</table>
fim table
</div>
</body>';


$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html);
$mpdf->Output("meu-pdf", "I");
