<?php
    //verificar se não está logado
    //if ( !isset ($_SESSION["hqs"]["id"] ) ) {
        //exit;
    //}

    //verificar se id está vazia
    if (empty ($id)) {
        echo "<script>
                alert('Não foi possível excluir o este cadastro');history.back();
            </script>";
            exit;
    }

    //verificar se existe uma aluno cadastrado
    $sql = "SELECT id
            FROM aluno
            WHERE aluno_id = :id
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
                alert('Não é possível excluir este cadastro pois possui turma relacionada');history.back();
            </script>";
    }

    //se existir, avisar e voltar
    

    //excluir aluno
    $sql = "DELETE FROM aluno WHERE id = :id limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    //verificar se não executou
    if (!$consulta->execute()){
        echo "<script>
                alert('Erro ao excluir');javascript:history.back();
            </script>";
    }

    //redirecionar para a listagem de alunos
    echo "<script>location.href='listar/aluno'</script>"

?>