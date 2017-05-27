<h3 class="title-section">HISTÓRICO DE PROJETOS & AVALIAÇÕES</h3>
<?php if ($type == 'f'): ?>
    <?php if (count($projectsUser)): ?>
        <div class="box-projects">
            <?php foreach ($projectsUser as $project): ?>
                <div class="project">
                    <h4 class="bold-italic"><?= $project->title ?></h4>
                    <div class="project-reputation">
                        <div>
                            <?php
                            if (!empty($project->user->picture)) {
                                $imgContratante = $project->user->picture;
                            } else {
                                $imgContratante = $this->Url->build('/front/img/user-default.png', true);
                            }
                            ?>
                            <img src="<?= $imgContratante ?>" class="img-user"/>
                            <a
                                href="<?= $this->Url->build('/visualizar-perfil/' . $project->user->id, true); ?>"
                                class="italic">
                                <?= $project->user->name . ' (contratante)' ?>
                            </a>
                            <br/>
                            <?php $avaliation = ''; ?>
                            <?php foreach ($project->user_reputations as $rep): ?>
                                <?php if ($rep->user_id == $user['id']): ?>
                                    <?php $avaliation = $rep->avaliation; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <p class="italic avaliation">
                                <?= $avaliation; ?>
                            </p>
                        </div>
                        <div class="flex">
                            <?= str_repeat('<i class="fa fa-star"></i>', $project->user_reputations[0]['grade']) ?>
                            <?= str_repeat('<i class="fa fa-star-o"></i>', 5 - $project->user_reputations[0]['grade']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="button" class="btn-padrao verMais">VER MAIS</button>
        </div>
    <?php endif; ?>
<?php else: ?>
    <?php if (count($projectsUser)): ?>
        <div class="box-projects">
            <?php foreach ($projectsUser as $project): ?>
                <div class="project">
                    <h4 class="bold-italic"><?= $project->title ?></h4>
                    <div class="project-reputation">
                        <div>
                            <?php
                            if (!empty($project->project_users_fixed[0]->user->picture)) {
                                $imgFreelancer = $project->project_users_fixed[0]->user->picture;
                            } else {
                                $imgFreelancer = $this->Url->build('/front/img/user-default.png', true);
                            }
                            ?>
                            <img src="<?= $imgFreelancer ?>" class="img-user"/>
                            <a
                                href="<?= $this->Url->build('/visualizar-perfil/' . $project->project_users_fixed[0]->user->id, true); ?>"
                                class="italic">
                                <?= $project->project_users_fixed[0]->user->name . ' (freelancer)' ?>
                            </a>
                            <br/>
                            <p class="italic avaliation">
                                <?php $avaliation = ''; ?>
                                <?php foreach ($project->user_reputations as $rep): ?>
                                    <?php if ($rep->user_id == $user['id']): ?>
                                        <?php $avaliation = $rep->avaliation; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <?= $avaliation ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="button" class="btn-padrao verMais">VER MAIS</button>
        </div>
    <?php endif; ?>
<?php endif; ?>
