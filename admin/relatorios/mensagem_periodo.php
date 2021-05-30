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
            <h2 class="centralizar mt-1">Relatório de Mensagens Recebidas por Período
            <br>' . $nomeMes . ' /  ' . $ano . '</h2>
            <table class="busca table">
                <thead border="1">
                    <th style="width: 15%;">Data</th>
                    <th style="width: 25%;">Aluno</th>
                    <th style="width: 20%;">Turma</th>
                    <th>Título da Mensagem</th>
                <thead>
                <tbody>
                    ';
    $sql = "SELECT m.*, date_format(m.data_postagem, '%d/%m/%Y') dp, p.id, p.nome, t.*, pe.*
            FROM mensagem AS m 
            INNER JOIN matricula AS ma ON (ma.id = m.matricula_id) 
            INNER JOIN pessoa AS p ON (p.id = ma.pessoa_id) 
            INNER JOIN turma_matricula AS tm ON (tm.matricula_id = ma.id) 
            INNER JOIN turma AS t ON (tm.turma_id = t.id)
            INNER JOIN periodo AS pe ON (pe.id = t.periodo_id)
            WHERE MONTH(m.data_postagem) = $mes AND YEAR(m.data_postagem) = $ano
            ORDER BY m.data_postagem DESC";

    $consulta = $pdo->prepare($sql);
    $consulta->execute();
    if ($consulta->rowCount() == 0) {
        echo '
        <tr>
        <td colspan="3" class="centralizar"><p style="color:#333; font-size:16px;"> 
        <b>Não existem registros </b></p> </td>
    </tr> ';
    } else {
        while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
            $data = $dados->dp;
            $titulo = $dados->titulo;
            $serie     = $dados->serie;
            $descricao = $dados->descricao;
            $periodo   = $dados->periodo;
            $nome = $dados->nome;

            echo  '
        <tr >
            <td> ' . $data . ' </td>
            <td> ' . $nome . ' </td>
            <td>' . $serie . ' ' . $descricao . ' / ' . $periodo . '</td>
            <td>' . $titulo . '</td>
        </tr>
        ';
        }
    }

    echo '
                <tbody>
                <tfoot >
                <td colspan="4" class="text-end" >Gerado em ' . date("d/m/Y H:i") . ', por ' . $usuario . ' </td>
                </tfoot>
            </table> </div>
    </body>';
} else {
    echo "
<div class='conatiner pt-5'>
<p class='alert alert-danger'> Não foi possível concluir a requisição </p>
</div>";
}
