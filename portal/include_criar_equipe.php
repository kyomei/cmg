                          <div class="row">
                            <div class="col-md-12">
                                <!-- Área criar equipe -->
                                <div class="card-box">
                                    <div class="row text-center">
                                        <div class="col-md-12">
                                            <h3>Você ainda não possui uma equipe</h3>
                                            <p class="pt-3"><a href="#" class="btn btn-lg btn-primary">Criar minha equipe</a></p>
                                        </div>
                                    </div>                    
                                </div><!-- End .\ Área criar equipe -->
                            </div>
                            <div class="col-md-12">
                                <!-- Criar equipe -->
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Encontre sua equipe</h3>
                                            <?php
                                            $equipes = $equipe->getEquipes();
                                            ?>

                                            <input class="form-control mb-3" id="myInput" type="text" placeholder="Search...">
                                            <ul class="list-group">
                                                <?php foreach ($equipes as $equipe): ?>
                                                    <a href="?id=<?= $equipe->id; ?>" class="list-group-item list-group-item-action">
                                                        <img src="../<?= $equipe->image; ?>" width="50" class="mr-2">
                                                        <span class="text-left"><?= $equipe->nome; ?> </span>
                                                        <span class="float-right" style="line-height: 50px">Total de membros: <?= ($usuario->getCountMembrosEquipe($equipe->id)->count); ?></span>
                                                    </a>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>                    
                                </div>
                            </div>
                        </div>