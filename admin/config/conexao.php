<?php
    //arquivo para conexão com o banco de dados Mysql

    $servidor   = "localhost";
    $usuario    = "root";
    $senha      = "";
    $banco      = "facilita_escola";

    try {
        $pdo = new PDO("mysql:host=$servidor;
			dbname=$banco;
			charset=utf8",
			$usuario,
			$senha);
        } catch (PDOException $erro) {

            //mensagem de erro
            $msg = $erro->getMessage();
    
            echo "<p>Erro ao conectar no banco de dados: $msg </p>";
    
        }