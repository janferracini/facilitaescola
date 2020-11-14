<?php
    //iniciar a sessão
    session_start();

    //encerrar a sessão
    unset ( $_SESSION["facilita_escola"] ); //apaga as variaveis da sessão

    //redirecionar para a página inicial
    header("Location: index.php");