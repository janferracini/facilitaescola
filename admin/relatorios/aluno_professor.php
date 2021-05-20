<?php
date_default_timezone_set('America/Sao_Paulo');

if ($_POST) {
    include "../config/conexao.php";
    include "functions.php";

    $professor_id = '';

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if (empty($professor_id)) {
        echo "O campo Professor deve ser preenchido";
    }

    $usuario = $_SESSION['facilita_escola']['nome'];
    $professor = getProfessor($professor_id);

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
        }
        .mt-1 {
            margin-top: 1em;
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
            <h2 class="centralizar mt-1">Relatório de Alunor por Professor <br>' . $professor . '</h2>
            <table class="busca table">
                <thead border="1">
                    <th>Aluno</th>
                    <th style="width: 25%;">Matrícula</th>
                    <th style="width: 25%;">Contato</th>
                <thead>
                <tbody>
                    ';

    $professor_id = getTurmaId($professor_id);

    $sql = "SELECT p.nome, p.telefone1, m.*, tm.*, t.*, g.*
            FROM pessoa as p
            INNER JOIN matricula as m on (m.pessoa_id = p.id)
            INNER JOIN turma_matricula as tm on (m.id = tm.matricula_id)
            INNER JOIN turma as t on (tm.turma_id = t.id)
            INNER JOIN grade as g on (g.turma_id = t.id)
            WHERE g.professor_id = $professor_id
            ORDER BY p.nome";

    $consulta = $pdo->prepare($sql);
    $consulta->execute();

    while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
        $nome = $dados->nome;
        $matricula = $dados->matricula;
        $telefone = $dados->telefone1;

        echo  '
        <tr >
            <td> ' . $nome . ' </td>
            <td style="width: 20%;">' . $matricula . '</td>
            <td style="width: 20%;">' . $telefone . '</td>
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
