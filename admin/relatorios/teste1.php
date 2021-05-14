<?php

require_once __DIR__ . '../../vendor/autoload.php';
date_default_timezone_set('America/Sao_Paulo');
$stylesheet = file_get_contents('../../dist/css/css-pdf.css');

$html = '
  <body style="font-family: Verdana, Tahoma, Geneva, sans-serif;">
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
        <p class="data float-right">Gedado em ' . date("d/m/Y H:i") . '</p>
      </div>
  </body>
';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html);
$mpdf->Output("meu-pdf", "I");
