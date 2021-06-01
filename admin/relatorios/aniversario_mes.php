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

    $nomeMes = getNomeMes($mes);
    $usuario = $_SESSION['facilita_escola']['nome'];

    echo '
    <style>
        body {
            font-family: Verdana, Tahoma, Geneva, sans-serif;
            font-size: 14px;
            background-color: #f8f9fa;
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
            margin-top:30px;
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
            margin-bottom:30px;
        }

        
        .btn-outline-laranja {
            color: var(--laranja);
            border-color: var(--laranja);
        }

        .btn-outline-laranja:hover {
            color: #fff;
            background-color: var(--laranja);
            border-color: var(--laranja);
        }

        @media print {
            .btn-imprimir {
                display: none;
            }
            .cabecalho{
                color: #000 !important;
            }

            footer {
                display: none;
            }
        }
    </style>
    <body>
        <div class="container">
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
            <h2 class="centralizar mt-1">Relatório de Aniversariantes do mês
            <br>' . $nomeMes . '</h2>
            <h4>Alunos:</h4>
            <table class="busca table">
                <thead border="1">
                    <th style="width: 15%;">Data</th>
                    <th>Nome</th>
                    <th style="width: 20%;">Turma</th>
                </thead>
                <tbody>';
    $sql = "SELECT p.nome, date_format(p.data_nascimento, '%d/%m/%Y') dp, t.*, pe.*
            FROM pessoa AS p
            INNER JOIN matricula AS m ON (m.pessoa_id = p.id)
            INNER JOIN turma_matricula AS tm ON (tm.matricula_id = m.id)
            INNER JOIN turma AS t ON (t.id = tm.turma_id)
            INNER JOIN periodo AS pe ON (pe.id = t.periodo_id)
            WHERE MONTH(p.data_nascimento) = $mes
            ORDER BY p.data_nascimento ASC";
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
            $data      = $dados->dp;
            $nome    = $dados->nome;
            $serie     = $dados->serie;
            $descricao = $dados->descricao;
            $periodo   = $dados->periodo;
            echo  '
                <tr >
                    <td> ' . $data . ' </td>
                    <td> ' . $nome . ' </td>
                    <td>' . $serie . ' ' . $descricao . ' / ' . $periodo . '</td>
                </tr>
                ';
        }
    }
    echo ' 
                </tbody>
            </table> 
            
            <h4>Professores:</h4>
            <table class="busca table">
                <thead border="1">
                    <th style="width: 15%;">Data</th>
                    <th>Nome</th>
                </thead>
                <tbody>';
    $sql = "SELECT p.nome, date_format(p.data_nascimento, '%d/%m/%Y') dp
            FROM pessoa AS p
            WHERE MONTH(p.data_nascimento) = $mes AND p.tipo_cadastro = 3
            ORDER BY p.data_nascimento ASC";
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
            $data      = $dados->dp;
            $nome    = $dados->nome;
            echo  '
                <tr >
                    <td> ' . $data . ' </td>
                    <td> ' . $nome . ' </td>
                </tr>';
        }
    }
    echo '
                </tbody>
            </table>
            <h4>Equipe Administrativa:</h4>
            <table class="busca table">
                <thead border="1">
                    <th style="width: 15%;">Data</th>
                    <th>Nome</th>
                </thead>
                <tbody>';
    $sql = "SELECT p.nome, date_format(p.data_nascimento, '%d/%m/%Y') dp
            FROM pessoa AS p
            WHERE MONTH(p.data_nascimento) = $mes AND p.tipo_cadastro = 1
            ORDER BY p.data_nascimento ASC";
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
            $data      = $dados->dp;
            $nome    = $dados->nome;

            echo  '
                <tr >
                    <td> ' . $data . ' </td>
                    <td> ' . $nome . ' </td>
                </tr>';
        }
    }

    echo '
                </tbody>

            </table>';

    echo '    
    <div class="text-end">
        <td>Gerado em ' . date("d/m/Y H:i") . ', por ' . $usuario . ' </td>
        
</div>
<form>
            <input type="button" class="float-right btn mb-3 btn-outline-laranja btn-imprimir" value="Imprimir" onClick="window.print()"/>
            <div class="clearfix"></div>
        </form>
    </div>
    </body>';
} else {
    echo "
<div class='conatiner pt-5'>
<p class='alert alert-danger'> Não foi possível concluir a requisição </p>
</div>";
}
