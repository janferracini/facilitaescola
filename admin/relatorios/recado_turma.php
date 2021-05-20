<?php
date_default_timezone_set('America/Sao_Paulo');

if ($_POST) {
    include "../config/conexao.php";
    include "functions.php";

    $turma_id = '';

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if (empty($turma_id)) {
        echo "O campo Turma deve ser preenchido";
    }


    $usuario = $_SESSION['facilita_escola']['nome'];
    $turma = getTurma($turma_id);

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
            <h2 class="centralizar mt-1">Relatório de Recados por Turma <br>' . $turma . '</h2>
            <table class="busca table">
                <thead border="1">
                    <th style="width: 25%;">Data</th>
                    <th>Título do Recado</th>
                <thead>
                <tbody>
                    ';
    $turma_id = getTurmaId($turma_id);

    $sql = "SELECT r.*, date_format(r.data_postagem, '%d/%m/%Y') dp, t.*
    FROM recado r
    INNER JOIN turma t ON (t.id = r.turma_id)
    WHERE t.id = $turma_id
    ORDER BY r.data_postagem DESC";

    $consulta = $pdo->prepare($sql);
    $consulta->execute();

    while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
        $data = $dados->dp;
        $titulo = $dados->titulo;

        echo  '
        <tr >
            <td style="width: 25%;"> ' . $data . ' </td>
            <td>' . $titulo . '</td>
        </tr>
        ';
    }

    echo '
                <tbody>
                <tfoot >
                <td colspan="3" class="text-end" >Gerado em ' . date("d/m/Y H:i") . ', por ' . $usuario . ' </td>
                </tfoot>
                
            </table>
        </div>
    </body>';
}
