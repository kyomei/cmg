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

        <!-- Bootstrap core CSS -->
        <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="https://getbootstrap.com/docs/4.0/examples/floating-labels/floating-labels.css" rel="stylesheet">
    </head>

    <body>
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
        <form class="form-signin" method="POST">
            <div class="text-center mb-4">
                <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
                <h1 class="h3 mb-3 font-weight-normal">Acesse sua conta!</h1>
                <p class="text-left">Preencha as informações abaixo:</p>
            </div>

            <div class="form-label-group">
                <input type="email" id="email" class="form-control" placeholder="Email address" name="email" required autofocus>
                <label for="email">Email address</label>
            </div>

            <div class="form-label-group">
                <input type="password" id="senha" class="form-control" placeholder="Password" name="senha" required>
                <label for="senha">Senha address</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Lembrar-me
                </label>
                <a href="register.php">Criar conta</a>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
            <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2018</p>
        </form>
    </body>
</html>
