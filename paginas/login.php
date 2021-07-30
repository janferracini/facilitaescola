<?php

$msg = NULL;

if ($_POST) {

    $login = $senha = "";

    if (isset($_POST["login"])) {
        $login = trim($_POST["login"]);
    }
    if (isset($_POST["senha"])) {
        $senha = trim($_POST["senha"]);
    }

    if (empty($login)) {
        $msg = '<p class="alert alert-danger"> Preencha o campo Login </p>';
    } else if (empty($senha)) {
        $msg = '<p class="alert alert-danger">Preencha o campo Senha</p>';
    } else {

        $sql = "SELECT id, nome, login, senha, tipo_cadastro, status
                FROM pessoa WHERE login = :login LIMIT 1";

        $consulta = $pdo->prepare($sql);

        $consulta->bindParam(":login", $login);

        $consulta->execute();
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if (empty($dados->id))
            $msg = '<p class="alert alert-danger">Usuário não existe</p>';
        else if (!password_verify($senha, $dados->senha))
            $msg = '<p class="alert alert-danger">Senha incorreta</p>';
        else {
            $_SESSION["facilita_escola"] = array(
                "id" => $dados->id,
                "nome" => $dados->nome,
                "tipo_cadastro" => $dados->tipo_cadastro,
                "status" => $dados->status
            );

            $tipo_cadastro = $dados->tipo_cadastro;
            $status = $dados->status;

            $msg = "<p class='alert alert-danger'>Usuário inativo</p>";

            if ($tipo_cadastro == 1 && $status == 1) {
                echo '<script>location.href="admin/index.php";</script>';
            } else if ($tipo_cadastro == 2 && $status == 1) {
                echo '<script>location.href="aluno/index.php";</script>';
            } else if ($tipo_cadastro == 3 && $status == 1) {
                echo '<script>location.href="professor/index.php";</script>';
            }
        }
    }
}
?>
<div class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#">
                <img src="img/FE-logo.png" style="width: 250px;" />
            </a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Inicar seu acesso</p>
                <?= $msg; ?>
                <form class="user" name="login" method="post" data-parsley-validate>
                    <div class="form-group">
                        <input type="text" name="login" class="form-control form-control-user" id="login" placeholder="Digite seu login" required data-parsley-required-message="Preencha seu login">
                    </div>
                    <div class="form-group">
                        <input type="password" name="senha" class="form-control form-control-user" id="senha" placeholder="Digite sua senha" required data-parsley-required-message="Coloque sua senha">
                    </div>

                    <div class="row">
                        <div class="col-8">
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-outline-laranja btn-block">Entrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>