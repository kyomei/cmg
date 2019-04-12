<?php 
session_start();

if(!empty($_SESSION['login'])){
    header("Location: index.php");
    exit;
}
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../../../favicon.ico">

        <title>Login - Crossfire Ghost Mode</title>

        <!-- Custom styles for this template -->
        <link href="./assets/css/login.css" rel="stylesheet">
    </head>

    <body>

        <h1>Crossfire Ghost Mode</h1>
        <form method="POST" id="form-login">
            <?php
                require_once 'classes/Usuario.class.php';
                $user = new Usuario();
                if (isset($_POST['email']) && !empty($_POST['email'])) {
                    if (isset($_POST['senha']) && !empty($_POST['senha'])) {
                        $email = addslashes($_POST['email']);
                        $senha = $_POST['senha'];
                        if ($user->login($email, $senha)):
                            header("Location: index.php");
                        else:
                            ?>
                
                            <div class="alert alert-danger" role="alert">
                                Usuário e/ou Senha inválidos!
                            </div>
                        <?php
                        endif;
                    }
                }
            ?>
            <label for="email">Email ou telefone</label>
            <input type="text" name="email" />
            <label for="senha">Senha</label>
            <input type="password" name="senha" />
            <input type="submit" value="Entrar" />
            <a href="#" id="reset-senha">Esqueceu a senha?</a>
        </form>
        <div class="form-info" id="create-account">
            <h2>Crie sua conta gratuitamente</h2>
            <a href="#" class="form-info btn">Criar conta</a>
        </div>

        <div class="form-reset hidden">
            <div class="reset-info">
                <div class="container">
                    <p>Digite seu endereço de e-mail. Você receberá um link para criar uma nova senha via e-mail.</p>
                </div>
            </div>
            <div class="reset-form">
                <div class="container">
                    <form method="GET">
                        <label for="email">Endereço de e-mail</label>
                        <input type="email" name="email" />
                        <input type="submit" value="Obter nova senha" />
                    </form>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="assets/js/script-login.js"></script>
    </body>
</html>
