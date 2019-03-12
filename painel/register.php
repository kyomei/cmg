<?php
require_once 'classes/Usuario.class.php';
$user = new Usuario();


// Define variables and set to empty values
$nomeErr = $emailErr = $senhaErr = $csenhaErr = "";
$nome = $email = $senha = $csenha = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Válida campo nome 
    if (empty($_POST["nome"])) {
        $nomeErr = "<i class='fa fa-close'> Informe seu nome do jogo";
    } else {
        $nome = teste_input($_POST["nome"]);
        // Check if name only contains letters and whitespace
        /* if (!preg_match("/^[a-zA-Z ]*$/", $nome)) {
          $nomeErr = "<i class='fa fa-close'> Apenas letras e espaços em branco permitidos";
          } */
    }
    // Válida campo email 
    if (empty($_POST["email"])) {
        $emailErr = "<i class='fa fa-close'> Campo email obrigatório";
    } else {
        $email = teste_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "<i class='fa fa-close'> Formato de email inválido";
        }
    }

    // Válida campo senha 
    if (empty($_POST["senha"])) {
        $senhaErr = "<i class='fa fa-close'> Informe sua senha de acesso";
    } else {
        $senha = teste_input($_POST["senha"]);
    }

    // Válida campo confirma senha 
    if (empty($_POST["csenha"])) {
        $csenhaErr = "<i class='fa fa-close'> Confirme sua senha de acesso";
    } else {
        $csenha = teste_input($_POST["csenha"]);
        if ($senha != $csenha) {
            $csenhaErr = "<i class='fa fa-close'> Sua senha está diferente da senha confirmada";
        } else {
            /* Efetue o cadastro no banco */
            $user->setNick($nome);
            $user->setEmail($email);
            $user->setSenha($senha);
            if ($user->registrar()) {
                header("Location: register.php?p=enviado");
            }
        }
    }
}

function teste_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <!--Standard Meta -->
        <meta charset = "utf-8"/>
        <meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1"/>
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0, maximum-scale=1.0">

        <!--Site Properties -->
        <title>Cadastro - Crossfire Ghost Mode</title>

        <!--Stylesheets -->
        <link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link href = "//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel = "stylesheet" id = "bootstrap-css">

        <style type = "text/css">
            @media(min-width: 768px) {
                .field-label-responsive {
                    padding-top: .5rem;
                    text-align: right;
                }
            }
        </style>
    </head>
    <body>
        <div class = "container" style = "margin-top: 80px;">
            <?php if (isset($_GET['p']) && $_GET['p'] == "enviado"): ?>            
                <div class = "row">
                    <div class = "col-md-3"></div>
                    <div class = "col-md-6">

                        <div class="card text-center">
                            <div class="card-header text-left">
                                <h2>Falta só mais alguns passos...</h2>
                            </div>
                            <div class="card-body">
                                <dl>
                                    <dt>1º Passo - Acesse seu e-mail</dt>
                                    <dd>Acesse o e-mail que você acabou de usar para fazer o cadastro.</dd>
                                    <dt>2º Passo - Encontre nossa mensagem de confirmação</dt>
                                    <dd>Procure e abra o e-mail com o título "Confirmar cadastro Crossfire ghost mode", que acabamos de lher enviar. Atenção: esse e-mail as vezes cai na caixa de spam ou nas abas extras do Gmail, então procure bem!</dd>
                                    <dt>3º Passo - Clique no link de confirmação!</dt>
                                    <dd>Leia atentamente o e-mail que lhe enviamos e clique no link de confirmação dentro do e-mail! Fazendo isso você estará oficialmente cadastrado!</dd>
                                </dl>  
                            </div>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <form class = "form-horizontal" role = "form" method = "POST" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class = "row">
                        <div class = "col-md-3"></div>
                        <div class = "col-md-6">
                            <h2>Register New User</h2>
                            <hr>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-3 field-label-responsive">
                            <label for = "name">Nick name</label>
                        </div>
                        <div class = "col-md-6">
                            <div class = "form-group">
                                <div class = "input-group mb-2 mr-sm-2 mb-sm-0">
                                    <div class = "input-group-addon" style = "width: 2.6rem"><i class = "fa fa-user"></i></div>
                                    <input type="text" name="nome" class="form-control" placeholder="John Doe"  autofocus>
                                </div>
                            </div>
                        </div>
                        <div class = "col-md-3">
                            <div class = "form-control-feedback">
                                <span class = "text-danger align-middle">
                                    <!--Put name validation error messages here -->
                                    <?php echo $nomeErr; ?></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 field-label-responsive">
                            <label for="email">E-Mail Address</label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                    <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                                    <input type="text" name="email" class="form-control" id="email" placeholder="you@example.com" >
                                </div>
                            </div>
                        </div>
                        <div class = "col-md-3">
                            <div class = "form-control-feedback">
                                <span class = "text-danger align-middle">
                                    <!--Put e-mail validation error messages here -->
                                    <?php echo $emailErr; ?></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-3 field-label-responsive">
                            <label for = "password">Password</label>
                        </div>
                        <div class = "col-md-6">
                            <div class = "form-group has-danger">
                                <div class = "input-group mb-2 mr-sm-2 mb-sm-0">
                                    <div class = "input-group-addon" style = "width: 2.6rem"><i class = "fa fa-key"></i></div>
                                    <input type="password" name="senha" class="form-control" id="password" placeholder="Password" >
                                </div>
                            </div>
                        </div>
                        <div class = "col-md-3">
                            <div class = "form-control-feedback">
                                <span class = "text-danger align-middle">
                                    <?php echo $senhaErr; ?></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-3 field-label-responsive">
                            <label for = "password">Confirm Password</label>
                        </div>
                        <div class = "col-md-6">
                            <div class = "form-group">
                                <div class = "input-group mb-2 mr-sm-2 mb-sm-0">
                                    <div class = "input-group-addon" style = "width: 2.6rem">
                                        <i class = "fa fa-repeat"></i>
                                    </div>
                                    <input type="password" name="csenha" class="form-control" id = "password-confirm" placeholder="Password" >
                                </div>
                            </div>
                        </div>
                        <div class = "col-md-3">
                            <div class = "form-control-feedback">
                                <span class = "text-danger align-middle">
                                    <?php echo $csenhaErr; ?></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-3"></div>
                        <div class = "col-md-6">
                            <button type = "submit" class = "btn btn-success"><i class = "fa fa-user-plus"></i> Register</button>
                        </div>
                    </div>
                </form>
            <?php endif; ?> 
        </div>
        <script src = "//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    </body>
</html>