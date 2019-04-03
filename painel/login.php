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
        <form action="" method="POST">
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
            <a href="#">Esqueceu a senha?</a>
        </form>
        <div class="form-info">
            <h2>Crie sua conta gratuitamente</h2>
            <a href="#" class="form-info btn">Criar conta</a>
        </div>
    </body>
</html>
