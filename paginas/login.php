<?php

$msg = NULL;

//verificar se foi dado post

if ($_POST) {
    //inicia as variaveis
    $login = $senha = "";
    //recuperar o login e a senha digitado
    if (isset($_POST["login"])) {
        $login = trim($_POST["login"]);
    }
    if (isset($_POST["senha"])) {
        $senha = trim($_POST["senha"]);
    }

    //verificar se os campos estao em branco
    if (empty($login)) {
        $msg = '<p class="alert alert-danger"> Preencha o campo Login </p>';
    } else if (empty($senha)) {
        $msg = '<p class="alert alert-danger">Preencha o campo Senha</p>';
    } else {
        //verificar se o login existe
        $sql = "select id, nome, login, senha, tipo_cadastro
                    from pessoa where login = :login limit 1";
        //apontar a conexão com o banco a utilizar
        //prepara a sql para exetutar 
        $consulta = $pdo->prepare($sql);
        //passar o parametro para o sql
        $consulta->bindParam(":login", $login);
        //executar o sql
        $consulta->execute();
        //puxar os dados do resultado
        $dados = $consulta->fetch(PDO::FETCH_OBJ); //msqli_fetch
        //verificar se existe usuario
        if (empty($dados->id))
            $msg = '<p class=!alert alert-danger>Usuário não existe</p>';
        else if (!password_verify($senha, $dados->senha))
            $msg = '<p class=!alert alert-danger>Senha incorreta</p>';
        //se deu tudo certo
        else {
            $_SESSION["facilita_escola"] = array(
                "id" => $dados->id,
                "nome" => $dados->nome,
                "tipo_cadastro" => $dados->tipo_cadastro
            );

            $tipo_cadastro = $dados->tipo_cadastro;
            
            $msg = "Deu certo ";
            //javascript para recirecionar
            if( $tipo_cadastro == 1 ) {
                echo '<script>location.href="admin/index.php";</script>';
            } else if($tipo_cadastro == 2) {
                echo '<script>location.href="aluno/index.php";</script>';
            } else if ($tipo_cadastro == 3) {
                echo '<script>location.href="professor/index.php";</script>';
            }
        }
    }
}
?>
<div class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="index.html">
                <img src="docs/assets/img/FE-logo.png" style="width: 250px;" />
            </a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Inicar seu acesso</p>
                <?=$msg;?> 
                <form class="user" name="login" method="post" data-parsley-validate>
                    <!-- campos de informação de login -->
                    <!-- <div class="input-group mb-3">
                        <input type="text" name="login" class="form-control" placeholder="Login">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <input type="text" name="login" class="form-control form-control-user" id="login" placeholder="Digite seu login" required data-parsley-required-message="Preencha seu login">
                    </div>

                    <!-- <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Senha">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <input type="password" name="senha" class="form-control form-control-user" id="senha" placeholder="Digite sua senha" required data-parsley-required-message="Coloque sua senha">
                    </div>

                    <!-- fim dos campos de informação de login -->

                    <div class="row">
                        <div class="col-8">
                            <!--<div class="icheck-orange">
                            <input type="checkbox" id="remember">
                            <label for="remember"> Lembrar-me</label>
                            </div>-->
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-outline-laranja btn-block">Entrar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mb-1">
                    <a href="forgot-password.html">Esqueci minha senha</a>
                </p>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->