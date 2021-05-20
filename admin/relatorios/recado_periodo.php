<?php

use Mpdf\Tag\H4;

date_default_timezone_set('America/Sao_Paulo');

if ($_POST) {
    include "../config/conexao.php";
    include "functions.php";

    $mes = $nomeMes = $ano = '';

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if (empty($mes)) {
        echo "O Mês deve ser selecionado";
        exit;
    }
    if (empty($ano)) {
        echo "O Ano deve ser preenchido";
        exit;
    }

    $nomeMes = getNomeMes($mes);
    $usuario = $_SESSION['facilita_escola']['nome'];

    echo '
    <style>
        body {
            font-family: Verdana, Tahoma, Geneva, sans-serif;
            font-size: 14px;
        }

        .table{
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            background-color: transparent;
        }
        
        .container {
            width: 100%;
            padding-right: 7.5px;
            padding-left: 7.5px;
            margin-right: auto;
            margin-left: auto;
        }
        
        .cabecalho{
        font-weight: bold;
        font-size: 30px;
        color: #ed8032;
        margin-bottom: 0;
        }

        .subcabecalho {
            font-size: 20px;
            margin-top: 0;
        }

        .centralizar {
            text-align: center;
        }
        
        .imagemlogo {
        width: 150px;
        margin-right: 30px; 
        }
        
        .data {
        text-align: right;
        }
        
        .float-left {
        float: left !important;
        }
        
        .float-right {
        float: right !important;
        }

        .busca{
            font-size: 14px;
            margin-top:50px;
            margin-bottom:30px;
        }
        .mt-1 {
            margin-top: 1em;
        }
        .mt-2 {
            margin-top: 2em;
        }
        .text-end {
            text-align: right !important;
        }
    </style>
    <body >
        <table style="width:100%">
            <tr>
                <td style="width: 20%;">
                    <img src="../img/FE-logo.png" class="imagemlogo" />
                </td>
                <td>
                    <p class="cabecalho">Facilita Escola</p>
                    <p class="subcabecalho">Gestão escolar de qualidade</p>
                </td>
            </tr>
        </table>
        <div class="container">
            <h2 class="centralizar mt-1">Relatório de Recados por Período
            <br>' . $nomeMes . ' /  ' . $ano . '</h2>
            <table class="busca table">
                <thead border="1">
                    <th style="width: 20%;">Data</th>
                    <th style="width: 20%;">Turma</th>
                    <th>Título do Recado</th>
                <thead>
                <tbody>
                    ';
    $sql = "SELECT r.*, date_format(r.data_postagem, '%d/%m/%Y') dp, t.*,  p.*
    FROM recado r
    INNER JOIN turma t ON (t.id = r.turma_id)
    INNER JOIN periodo p ON (p.id = t.periodo_id)
    WHERE MONTH(r.data_postagem) = $mes AND YEAR(r.data_postagem) = $ano
    ORDER BY r.data_postagem DESC";

    $consulta = $pdo->prepare($sql);
    $consulta->execute();


    while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
        $data = $dados->dp;
        $titulo = $dados->titulo;
        $serie     = $dados->serie;
        $descricao = $dados->descricao;
        $periodo   = $dados->periodo;
        $turma_id = $dados->turma_id;

        echo  '
        <tr >
            <td> ' . $data . ' </td>
            <td>' . $serie . ' ' . $descricao . ' / ' . $periodo . '</td>
            <td>' . $titulo . '</td>
        </tr>
        ';
    }

    echo '
                <tbody>
                <tfoot >
                <td colspan="3" class="text-end" >Gerado em ' . date("d/m/Y H:i") . ', por ' . $usuario . ' </td>
                </tfoot>
            </table> </div>
    </body>';
} else {
    echo "
<div class='conatiner pt-5'>
<p class='alert alert-danger'> Não foi possível concluir a requisição </p>
</div>";
}
