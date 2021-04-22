<?php
    //verificar se não está logado
    if ( !isset ($_SESSION["facilita_escola"]["id"] ) ) {
        exit;
    }

    //verificar se id está vazia
    if (empty ($id)) {
        echo "<script>
                alert('Não foi possível excluir o registro');history.back();
            </script>";
            exit;
    }

?>