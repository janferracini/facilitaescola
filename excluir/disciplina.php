<?php
    //verificar se não está logado
    //if ( !isset ($_SESSION["hqs"]["id"] ) ) {
        //exit;
    //}

    //verificar se id está vazia
    if (empty ($id)) {
        echo "<script>
                alert('Não foi possível excluir o registro');history.back();
            </script>";
            exit;
    }

    //verificar se existe uma grade cadastrada com esse turma
    $sql = "SELECT id
            FROM disciplina
            WHERE disciplina_id = :id
            LIMIT 1";

    //prepara a sql para executar
    $consulta = $pdo->prepare($sql);
    //passar o id do parametro
    $consulta->bindParam(":id",$id);
    //executa o sql
    $consulta->execute();
    //recuperar os dados selecionados
    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    //se existir  avisar e voltar
    if (!empty ($dados->id)) {
        //se o id não está vazio, não posso excluir
        
        echo "<script>
                alert('Não é possível excluir este registro pois contém turma cadastrada');history.back();
            </script>";
    }

    //se existir, avisar e voltar
    

    //excluir a editora
    $sql = "DELETE FROM disciplina WHERE id = :id limit 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    //verificar se não executou
    if (!$consulta->execute()){
        echo "<script>
                alert('Erro ao excluir');javascript:history.back();
            </script>";
    }

    //redirecionar para a listagem de editoras
    echo "<script>location.href='listar/disciplina'</script>"

?>