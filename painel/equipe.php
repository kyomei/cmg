<?php
// Definindo titilo da pagina
$config['title'] = 'Equipe';
$config['navbar'] = 'equipe';
?>
<?php include_once '_includes/header.php'; ?> 
<?php
$equipe = new Equipe();
$usuario = new Usuario();
$equipeApply = new EquipeApply();
?>
<!--  -->
<?php 
if (isset($_GET['page']) && $_GET['page'] == "apply") {
    
    $id_equipe = $_GET['id'];
    
    if (isset($_GET['action']) && $_GET['action'] == "cancelar") {
        $path = $_SERVER['HTTP_HOST'].'/';
        if ($equipeApply->cancelar($logado->getId())) {
            echo "<script>javascript:history.back(-1)</script>";
            //echo "<script>alert('Solicitação de aplicação na equipe foi cancelada');window.location.href = ?id='.$id_equipe.';</script>";
        } else {
             echo "<script>alert('Não foi possível cancelar solicitação');</script>";             
             echo "<script>javascript:history.back(-1)</script>";
        }
    } else {
        /* Request get aplicar equipe */
        if ($equipeApply->aplicar($logado->getId(), $id_equipe)){           
            echo "<script>javascript:history.back(-1)</script>";
        } else {
            header("Location: equipe.php?page=equipe-quit-error");
        }
    }    
    
}
?>
<!-- Request get Cancelar aplicação na equipe -->
<?php
if (isset($_GET['page']) && $_GET['page'] == "equipe-quit") {

    if ($logado->sairEquipe($logado->equipe)) {
        header("Location: equipe.php");
    } else {
        header("Location: equipe.php?page=equipe-quit-error");
    }
}
?>
<!-- Request post atualizando dados do usuário logado -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = teste_input($_POST["nome"]);
    $nick = teste_input($_POST["nick"]);
    $whatsapp = teste_input($_POST["whatsapp"]);
    $facebook = teste_input($_POST["facebook"]);
    $youtube = teste_input($_POST["youtube"]);
    $image = teste_input($_POST["image"]);

    (!empty($nome)) ? $logado->setNome($nome) : '';
    (!empty($nick)) ? $logado->setNick($nick) : '';
    $logado->setWhatsapp($whatsapp);
    $logado->setFacebook($facebook);
    $logado->setYoutube($youtube);
    $logado->setImage($image);
    if ($logado->salvar()) {
        header("Location: equipe.php");
    }
}

function teste_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">

                <!-- Informações do usuário logado -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box text-center">                           
                            <div class="member-card">
                                <div class="icon-edit"><i class="fas fa-edit " data-toggle="modal" data-target="#myProfile"></i></div>
                                <!-- Avatar e descrição -->
                                <?php if (!empty($logado->getImage())): ?>
                                    <img src="<?= $logado->getImage(); ?>" class="rounded-circle img-thumbnail" alt="profile-image" width="150">
                                <?php else: ?>
                                    <img src="../assets/images/painel/profile-default.png" class="rounded-circle img-thumbnail" alt="profile-image" width="150">
                                <?php endif; ?>
                                <h4><?= $logado->getNick(); ?></h4>
                                <p class="text-muted"><?= $logado->getNome(); ?></p>

                                <!-- Informações pessoais -->
                                <div class="text-left">                            
                                    <p class=""><strong>Equipe:</strong> <?= empty($logado->equipe) ? '<span class="text-muted">Sem equipe</span>' : $logado->equipe->getNome(); ?></p>                            
                                    <p class=""><strong>Email:</strong> <?= $logado->getEmail(); ?></p>
                                    <?= empty($logado->getWhatsapp()) ? '' : "<p><strong>WhatsApp:</strong>" . $logado->getWhatsapp() . "</p>"; ?>                            
                                </div>
                                <!-- Redes sociais links -->
                                <div class="d-flex  text-left">
                                    <?= empty($logado->getFacebook()) ? '' : '<div class="pl-1"><a href="' . $logado->getFacebook() . '" title="Facebook do jogador"><i class="fab fa-facebook" style="font-size: 30px;"></i></a></div>'; ?>
                                    <?= empty($logado->getYoutube()) ? '' : '<div class="pl-1"><a href="' . $logado->getYoutube() . '" title="Canal do jogador"><i class="fab fa-youtube" style="font-size: 30px; color: red;"></i></a></div>'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End .\ Informações usuário logado -->

                <!-- Histórico de particação do jogador -->
                <div class="row">
                    <div class="col-md-12">      
                        <div class="card-box">
                            <h4>Participação em eventos</h4>
                            <strong>Mix's</strong>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">100%</div>
                            </div><br />

                            <strong>Draft's</strong>
                            <div class="progress">
                                <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:80%">80%</div>
                            </div><br />

                            <strong>Campeonato's</strong>
                            <div class="progress">
                                <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:60%">60%</div>
                            </div><br />
                        </div>
                    </div>
                </div><!-- End .\ Histórico de particação do jogador -->
            </div>
            <div class="col-lg-9 col-md-12">
                <!-- Area de equipe pesquisada -->
                <?php
                $equipe_id = (isset($_GET['id'])) ? $_GET['id'] : '';
                if (is_numeric($equipe_id)) {
                    ?>
                    <?php
                    $equipeProfile = new Equipe();
                    $equipeProfile->getEquipe($equipe_id);
                    ?>
                    <!-- Perfil da equipe -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Description equipe -->
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="../<?= $equipeProfile->getImage(); ?>" alt="profile-image" width="100">
                                    </div>
                                    <div class="col-md-10 equipe-descricao"> 
                                        <?php 
                                            // Verifica se usuário logado já possui uma equipe
                                            if (empty($logado->equipe)) {
                                                
                                                // verificar se o usuario logado já deu apply em alguma equipe
                                                
                                                if($equipeApply->getApply($logado->getId())) {
                                                    
                                                    echo '<a href="'.basename($_SERVER["REQUEST_URI"].'&page=apply&action=cancelar').'" class="icon-quit btn-sm btn btn-outline-danger text-danger">Cancelar solicitação</a>';
                                                    
                                                } else {
                                                    echo '<a href="'.basename($_SERVER["REQUEST_URI"].'&page=apply').'" class="icon-quit btn-sm btn btn-outline-dark text-dark">Aplicar</a>';
                                                }
                                                
                                                
                                            }
                                        ?>
                                        <h3><?= $equipeProfile->getNome(); ?></h3>
                                        <p><?= $equipeProfile->getDescricao(); ?></p>
                                    </div>
                                </div>                    
                            </div>
                        </div>
                    </div><!-- End .\ Perfil da equipe -->

                    <div class="row">
                        <div class="col-md-12 float-lg-right">
                            <!-- area de membros -->
                        </div>
                        
                          <!-- histórico de partidas -->
                            <div class="col-md-12 history-equipe">
                                <hr> 
                                <?php
                                $jogos = new PartidaAmistoso();
                                $partidas = $jogos->getPartidasEquipe($equipe_id);
                                $cont = 1;
                                ?>
                                <!-- Nav tabs -->
                                <ul class="nav nav-pills mb-4">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">Amistoso</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" href="#">Draft</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" href="#">Campeonato</a>
                                    </li>
                                </ul>

                                <?php foreach ($partidas as $partida): ?>
                                    <!-- partida <?= $cont; ?> -->
                                    <div class="card-history card-box">
                                        <div class="card-history-title d-flex">
                                            <div class="mt-1">CGM 2019 - Jogo amistoso <?= $cont++; ?></div>
                                            <div class="ml-auto"><a href="#" class="btn btn-info btn-sm"><i class="fas fa-list"></i> Detalhes</a></div>
                                            <?= ($partida->getLink()) ? '<div class="ml-2"><a href="' . $partida->getLink() . '" class="btn btn-danger btn-sm" target="_blank"><i class="fas fa-video"></i> Assistir</a></div>' : ''; ?>
                                        </div>
                                        <div class="card-history-body">
                                            <div class="d-flex mb-3">
                                                <div class="p-2">
                                                    <div class="d-flex flex-row">
                                                        <?php
                                                        $placar = explode("x", $partida->getPlacar());
                                                        $horario = date('d/m/Y - H:i', strtotime($partida->getHorario()));
                                                        ?>
                                                        <div class="p-2 text-center"><img src="../<?= $partida->getDesafiante()->getImage(); ?>" alt="profile-image" width="65"><strong class="px-2"><?= $partida->getDesafiante()->getNome(); ?></strong></div>
                                                        <div class="p-2 pl-3 pr-3 align-self-center"><h1 class="display-5"><?= $placar[0]; ?></h1></div>
                                                        <div class="p-2 pl-3 pr-3 align-self-center"><h1 class="display-5">VS</h1></div>
                                                        <div class="p-2 pl-3 pr-3 align-self-center"><h1 class="display-5"><?= $placar[1]; ?></h1></div>
                                                        <div class="p-2 text-center"><img src="../<?= $partida->getDesafiado()->getImage(); ?>" alt="profile-image" width="65"><strong class="px-2"><?= $partida->getDesafiado()->getNome(); ?></strong></div>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="pt-2 text-muted"><?= $horario; ?></div>
                                                    </div>
                                                </div>
                                                <div class="p-2 ml-auto">
                                                    <table class="table-striped table-bordered">
                                                        <tr>
                                                            <td><img src="../<?= $partida->getDesafiante()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>kyomei</td>
                                                            <td><img src="../<?= $partida->getDesafiado()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>n4paaa</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="../<?= $partida->getDesafiante()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>kondziLla</td>
                                                            <td><img src="../<?= $partida->getDesafiado()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>PRO_HS</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="../<?= $partida->getDesafiante()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>[G]Shiro</td>
                                                            <td><img src="../../<?= $partida->getDesafiado()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>zezinhoo157</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="../<?= $partida->getDesafiante()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>TheSprayDead</td>
                                                            <td><img src="../<?= $partida->getDesafiado()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>Pedrinhodavsf</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="../<?= $partida->getDesafiante()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>lDarkFire</td>
                                                            <td><img src="../<?= $partida->getDesafiado()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>semQQzinho</td>
                                                        </tr>
                                                    </table> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End.\ partida 1 -->
                                <?php endforeach; ?> 
                            </div><!-- End. \ Histórico de partidas -->
                    </div>
                <?php } else { ?>


                    <!-- Area da equipe do jogador logado -->
                    <?php if (!empty($logado->equipe)): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Description equipe -->
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="../<?= $logado->equipe->getImage(); ?>" alt="profile-image" width="100">
                                        </div>
                                        <div class="col-md-10 equipe-descricao">                                            
                                            <a href="#" class="icon-quit btn-sm btn btn-outline-dark text-dark" data-toggle="modal" data-target="#myQuitEquipe"><i class="fas fa-sign-out-alt"></i> Sair equipe</a>
                                            <h3><?= $logado->equipe->getNome(); ?> 
                                            <?php 
                                                if($logado->equipe->getLider() == $logado->getId()){
                                                   echo '<sup class="icon-edit"><i class="fas fa-edit" data-toggle="modal" data-target="#myProfileEquipe"></i></sup>';
                                                } 
                                            ?>
                                                </h3>
                                            <p><?= $logado->equipe->getDescricao(); ?></p>
                                        </div>
                                    </div>                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 float-lg-right">
                                <!-- area de membros -->
                                <div class="row card-equipe">
                                    <div class="col-md-4">                                                
                                        <div class="card-box border-left-primary cursor-pointer" data-toggle="modal" data-target="#showMembrosEquipe">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Membros</div>
                                                        <div class="h5 mb-0 font-weight-bold"><?= count($logado->equipe->getMembros($logado->equipe->getId())); ?></div>
                                                    </div>
                                                    <div class="col-auto"><i class="fas fa-users fa-2x"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card-box border-left-primary cursor-pointer">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Solicitações</div>
                                                        <div class="h5 mb-0 font-weight-bold">18</div>
                                                    </div>
                                                    <div class="col-auto"><i class="fas fa-comments fa-2x"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card-box border-left-primary">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Convite</div>
                                                        <div class="h5 mb-0 font-weight-bold">18</div>
                                                    </div>
                                                    <div class="col-auto"><i class="fas fa-comments fa-2x"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- histórico de partidas -->
                            <div class="col-md-12 history-equipe">
                                <hr> 

                                <?php
                                $jogos = new PartidaAmistoso();
                                $partidas = $jogos->getPartidasEquipe($logado->equipe->getId());
                                $cont = 1;
                                ?>
                                <!-- Nav tabs -->
                                <ul class="nav nav-pills mb-4">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">Amistoso</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" href="#">Draft</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" href="#">Campeonato</a>
                                    </li>
                                </ul>
                                <?php foreach ($partidas as $partida): ?>
                                    <!-- partida <?= $cont; ?> -->
                                    <div class="card-history card-box">
                                        <div class="card-history-title d-flex">
                                            <div class="mt-1">CGM 2019 - Jogo amistoso <?= $cont++; ?></div>
                                            <div class="ml-auto"><a href="#" class="btn btn-info btn-sm"><i class="fas fa-list"></i> Detalhes</a></div>
                                            <?= ($partida->getLink()) ? '<div class="ml-2"><a href="' . $partida->getLink() . '" class="btn btn-danger btn-sm" target="_blank"><i class="fas fa-video"></i> Assistir</a></div>' : ''; ?>
                                        </div>
                                        <div class="card-history-body">
                                            <div class="d-flex mb-3">
                                                <div class="p-2">
                                                    <div class="d-flex flex-row">
                                                        <?php
                                                        $placar = explode("x", $partida->getPlacar());
                                                        $horario = date('d/m/Y - H:i', strtotime($partida->getHorario()));
                                                        // $data = explode("-", $partida->getHorario());
                                                        //$hota = explode(":", $partida->getHorario())
                                                        ?>
                                                        <div class="p-2 text-center"><img src="../<?= $partida->getDesafiante()->getImage(); ?>" alt="profile-image" width="65"><strong class="px-2"><?= $partida->getDesafiante()->getNome(); ?></strong></div>
                                                        <div class="p-2 pl-3 pr-3 align-self-center"><h1 class="display-5"><?= $placar[0]; ?></h1></div>
                                                        <div class="p-2 pl-3 pr-3 align-self-center"><h1 class="display-5">VS</h1></div>
                                                        <div class="p-2 pl-3 pr-3 align-self-center"><h1 class="display-5"><?= $placar[1]; ?></h1></div>
                                                        <div class="p-2 text-center"><img src="../<?= $partida->getDesafiado()->getImage(); ?>" alt="profile-image" width="65"><strong class="px-2"><?= $partida->getDesafiado()->getNome(); ?></strong></div>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="pt-2 text-muted"><?= $horario; ?></div>
                                                    </div>
                                                </div>
                                                <div class="p-2 ml-auto">
                                                    <table class="table-striped table-bordered">
                                                        <tr>
                                                            <td><img src="/<?= $partida->getDesafiante()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>kyomei</td>
                                                            <td><img src="/<?= $partida->getDesafiado()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>n4paaa</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="/<?= $partida->getDesafiante()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>kondziLla</td>
                                                            <td><img src="/<?= $partida->getDesafiado()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>PRO_HS</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="/<?= $partida->getDesafiante()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>[G]Shiro</td>
                                                            <td><img src="/<?= $partida->getDesafiado()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>zezinhoo157</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="/<?= $partida->getDesafiante()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>TheSprayDead</td>
                                                            <td><img src="/<?= $partida->getDesafiado()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>Pedrinhodavsf</td>
                                                        </tr>
                                                        <tr>
                                                            <td><img src="/<?= $partida->getDesafiante()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>lDarkFire</td>
                                                            <td><img src="/<?= $partida->getDesafiado()->getImage(); ?>" alt="profile-image" width="16"> </td>
                                                            <td>semQQzinho</td>
                                                        </tr>
                                                    </table> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End.\ partida 1 -->
                                <?php endforeach; ?> 
                            </div><!-- End. \ Histórico de partidas -->
                        </div>
                    <?php else: ?>
                    
                    <?php  if($equipeApply->getApply($logado->getId())) {?>
                    
                        <!-- Mostrar clã aplicado -->
                        <?php 
                            $result = $equipeApply->getApply($logado->getId());                            
                            echo '<script type="text/javascript">window.location.href="equipe.php?id='.$result->getEquipe()->getId().'";</script>';
                        ?>                        
                        <!-- End .\ Mostrar clã aplicado -->
                    
                    <?php } else { ?>
                        <!-- Criar equipe -->
                            <?php include_once 'include_criar_equipe.php';?>
                        <!-- End .\ Criar equipe -->
                    <?php } ?>
                        
                    <?php endif; ?>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<!-- The Modal - Deixar equipe myQuitEquipe -->
<!-- The Modal -->
<div class="modal fade" id="myQuitEquipe">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tem certeza que deseja sair da equipe?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Selecione "Confirmar" para sair da equipe <?= (empty($logado->equipe)) ? null : $logado->equipe->getNome(); ?>.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="?page=equipe-quit">Confirmar</a>
            </div>

        </div>
    </div>
</div>
<?php if($logado->equipe->getLider() == $logado->getId()){?>
<!-- The Modal - Edit profile equipe -->
<div class="modal fade" id="myProfileEquipe">
    <div class="modal-dialog modal-lg">        
        <form role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Dados da equipe</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <!-- Campo nome -->
                    <div class="form-group col-sm-4 col-xs-6">
                        <label for="nome">Nome</label>
                        <input type="text" value="<?= $logado->equipe->getNome(); ?>" name="nome" class="form-control" required="required">
                    </div>
                    <!-- Campo nick do jogador -->
                    <div class="form-group col-sm-12 col-xs-12">	
                        <label for="descricao">Descrição</label>
                        <textarea cols="5" rows="5" name="descricao" class="form-control"><?=$logado->equipe->getDescricao();?></textarea>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input class="btn btn-danger" type="submit" value="Atualizar">
                </div>
            </div>

        </form>
    </div>
</div>
<!-- End .\ The Modal - Edit profile equipe -->
<?php } ?>

<!-- The Modal - Edit profile user -->
<div class="modal fade" id="myProfile">
    <div class="modal-dialog modal-lg">        
        <form role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Dados do usuário</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Campo nome -->
                        <div class="form-group col-sm-4 col-xs-6">
                            <label for="nome">Nome</label>
                            <input type="text" value="<?= $logado->getNome(); ?>" name="nome" class="form-control" required="required">
                        </div>
                        <!-- Campo nick do jogador -->
                        <div class="form-group col-sm-4 col-xs-6">	
                            <label for="nick">Nick</label>
                            <input type="text" value="<?= $logado->getNick(); ?>" name="nick" class="form-control"  required="required">
                        </div>

                        <!-- Campo Whatsapp -->
                        <div class="form-group col-sm-4">
                            <label for="whatsapp">WhatsApp</label>
                            <input type="text" value="<?= $logado->getWhatsapp(); ?>" name="whatsapp" class="form-control" placeholder="11 4321-1234">
                        </div>

                        <!-- Campo facebook  -->
                        <div class="form-group col-sm-12 col-xs-12">
                            <label for="facebook">Facebook</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">https://facebook.com/</span>
                                </div>
                                <input type="text" class="form-control" name="facebook"  value="<?= $logado->getFacebook(); ?>"placeholder="crossfireghostmode">
                            </div>
                        </div>
                        <!-- Campo Youtube  -->
                        <div class="form-group col-sm-12 col-xs-12">
                            <label for="youtube">Youtube</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">https://youtube.com/channel/</span>
                                </div>
                                <input type="text" class="form-control" name="youtube"  value="<?= $logado->getYoutube(); ?>"  placeholder="crossfireghostmode">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="imagem">Imagem do usuário</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input class="btn btn-danger" type="submit" value="Atualizar">
                </div>
            </div>

        </form>
    </div>
</div>


<!-- The Modal - Show membros da equipe -->
<div class="modal fade" id="showMembrosEquipe">
    <div class="modal-dialog modal-lg">        
        <form role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Lista de membros</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input class="btn btn-danger" type="submit" value="Atualizar">
                </div>
            </div>

        </form>
    </div>
</div>
<!-- End .\ The Modal - Show membros da equipe -->
<?php include_once '_includes/footer.php'; ?>