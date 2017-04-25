<?php if (count($projects)): ?>
    <div class="panel-group" id="accordion">
        <?php foreach ($projects as $project): ?>
            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion"
                     href="#collapse<?= $project['id'] ?>">
                    <div class="status">
                        <div class="<?= strtolower($project['status']['content']['title']) ?>">
                            <i class="<?= $project['status']['content']['icon'] ?>"></i>
                            <span><?= strtoupper($project['status']['content']['title']) ?></span>
                        </div>
                    </div>
                    <h4 class="panel-title <?= $project['late'] == '1' ? 'late' : '' ?>">
                        <?= $project['title'] ?>
                    </h4>
                </div>
                <div id="collapse<?= $project['id'] ?>" class="panel-collapse collapse">
                    <section class="content">
                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="prazos-<?= $project['id'] ?>" class="tab-pane fade">
                                    <h4 class="normal">
                                        Prazo final para entrega deste projeto
                                        <span
                                            class="date-end"><?= $project['date_end']->i18nFormat('dd/MM/yyyy'); ?></span>
                                    </h4>
                                </div>
                                <div id="projeto-<?= $project['id'] ?>" class="tab-pane fade in active projeto">
                                    <div class="top-informations">
                                        <span>Orçamento: R$ <?= number_format($project['budget'], 2, '.', ',') ?></span>
                                        <?php
                                        $dev = isset($project['project_users_fixed']) && !empty($project['project_users_fixed']) ? $project['project_users_fixed'][0] : '';
                                        ?>
                                        <?php if ($this->request->session()->read('Auth.User.type') == 'c'): ?>
                                            <?php if (!empty($dev)): ?>
                                                <button
                                                    data-dev="<?= $dev['user_id'] ?>-freelancer"
                                                    data-project="<?= $project['id'] ?>"
                                                    class="btn btn-circle open-partner">
                                                    Freelancer escolhido&nbsp;&nbsp;<i class="fa fa-user"></i>
                                                </button>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <button
                                                data-dev="<?= $project['user_id'] ?>-contractor"
                                                data-project="<?= $project['id'] ?>"
                                                class="btn btn-circle open-partner">
                                                Contratante deste projeto&nbsp;&nbsp;<i class="fa fa-user"></i>
                                            </button>
                                        <?php endif; ?>

                                        <div class="user-window project-window-<?= $project['id'] ?>">
                                            <img
                                                src="<?= $this->Url->build('/front/img/user-default.png', true); ?>"
                                                class="picture img-responsive"/>
                                            <div class="informations">
                                                <h4 class="name normal"></h4>
                                                <h6 class="created normal"></h6>
                                                <h5 class="finished normal"></h5>
                                                <button class="btn-padrao white">VISUALIZAR PERFIL</button>
                                            </div>
                                        </div>

                                        <button
                                            class="btn btn-circle open-anexo">
                                            <i class="fa fa-paperclip"></i>
                                        </button>
                                    </div>
                                    <div class="skills">
                                        <span class="normal">Habilidades Necessárias:</span>
                                        <?php if (count($project['project_skills'])): ?>
                                            <ul class="skills-list light">
                                                <?php foreach ($project['project_skills'] as $skill): ?>
                                                    <li><?= $skill->skill->name ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p
                                                class="italic">Não foram adicionadas habilidades para este projeto</p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="description">
                                        <span class="normal">Descrição:</span>
                                        <p class="normal">
                                            <?= $project['description'] ?>
                                        </p>
                                    </div>
                                </div>
                                <div id="avaliacao-<?= $project['id'] ?>" class="tab-pane fade">
                                    <?php if ($project['status']['id'] !== '2'): ?>
                                        <h4 class="italic">Você ainda não finalizou este projeto</h4>
                                    <?php endif; ?>
                                </div>
                                <div id="time-line-<?= $project['id'] ?>" class="tab-pane fade">
                                    <!-- TIMELINE -->
                                    <div id="timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                     width="21px" height="20px" viewBox="0 0 21 20" enable-background="new 0 0 21 20" xml:space="preserve">
<path fill="#FFFFFF" d="M19.998,6.766l-5.759-0.544c-0.362-0.032-0.676-0.264-0.822-0.61l-2.064-4.999
	c-0.329-0.825-1.5-0.825-1.83,0L7.476,5.611c-0.132,0.346-0.462,0.578-0.824,0.61L0.894,6.766C0.035,6.848-0.312,7.921,0.333,8.499
	l4.338,3.811c0.279,0.246,0.395,0.609,0.314,0.975l-1.304,5.345c-0.199,0.842,0.708,1.534,1.468,1.089l4.801-2.822
	c0.313-0.181,0.695-0.181,1.006,0l4.803,2.822c0.759,0.445,1.666-0.23,1.468-1.089l-1.288-5.345
	c-0.081-0.365,0.035-0.729,0.313-0.975l4.34-3.811C21.219,7.921,20.855,6.848,19.998,6.766z"/>
</svg>

                                            </div>
                                            <div class="timeline-content">
                                                <h2>LOREM IPSUM DOLOR</h2>
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                    Atque, facilis quo maiores magnam modi ab libero praesentium blanditiis.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="timeline-item">
                                            <div class="timeline-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                     width="21px" height="20px" viewBox="0 0 21 20" enable-background="new 0 0 21 20" xml:space="preserve">
<g>
    <path fill="#FFFFFF" d="M17.92,3.065l-1.669-2.302c-0.336-0.464-0.87-0.75-1.479-0.755C14.732,0.008,7.653,0,7.653,0v5.6
		c0,0.096-0.047,0.185-0.127,0.237c-0.081,0.052-0.181,0.06-0.268,0.02l-1.413-0.64C5.773,5.183,5.69,5.183,5.617,5.215l-1.489,0.65
		c-0.087,0.038-0.19,0.029-0.271-0.023c-0.079-0.052-0.13-0.141-0.13-0.235V0H2.191C1.655,0,1.233,0.434,1.233,0.97
		c0,0,0.025,15.952,0.031,15.993c0.084,0.509,0.379,0.962,0.811,1.242l2.334,1.528C4.671,19.905,4.974,20,5.286,20h10.307
		c1.452,0,2.634-1.189,2.634-2.64V4.007C18.227,3.666,18.12,3.339,17.92,3.065z M16.42,17.36c0,0.464-0.361,0.833-0.827,0.833H5.341
		l-1.675-1.089h10.341c0.537,0,0.953-0.44,0.953-0.979V2.039l1.459,2.027V17.36L16.42,17.36z"/>
</g>
</svg>

                                            </div>
                                            <div class="timeline-content right">
                                                <h2>LOREM IPSUM DOLOR</h2>
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque, facilis quo. Maiores magnam modi ab libero praesentium blanditiis consequatur aspernatur accusantium maxime molestiae sunt ipsa.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="timeline-item">
                                            <div class="timeline-icon">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                     width="21px" height="20px" viewBox="0 0 21 20" enable-background="new 0 0 21 20" xml:space="preserve">
<path fill="#FFFFFF" d="M19.998,6.766l-5.759-0.544c-0.362-0.032-0.676-0.264-0.822-0.61l-2.064-4.999
	c-0.329-0.825-1.5-0.825-1.83,0L7.476,5.611c-0.132,0.346-0.462,0.578-0.824,0.61L0.894,6.766C0.035,6.848-0.312,7.921,0.333,8.499
	l4.338,3.811c0.279,0.246,0.395,0.609,0.314,0.975l-1.304,5.345c-0.199,0.842,0.708,1.534,1.468,1.089l4.801-2.822
	c0.313-0.181,0.695-0.181,1.006,0l4.803,2.822c0.759,0.445,1.666-0.23,1.468-1.089l-1.288-5.345
	c-0.081-0.365,0.035-0.729,0.313-0.975l4.34-3.811C21.219,7.921,20.855,6.848,19.998,6.766z"/>
</svg>

                                            </div>
                                            <div class="timeline-content">
                                                <h2>LOREM IPSUM DOLOR</h2>
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque, facilis quo. Maiores magnam modi ab libero praesentium blanditiis consequatur aspernatur accusantium maxime molestiae sunt ipsa.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($this->request->session()->read('Auth.User.type') == 'c'): ?>
                                    <div id="interested-<?= $project['id'] ?>" class="tab-pane fade">
                                        <?php if (count($project['project_users_intersted'])): ?>
                                            <ul class="users-interested">
                                                <?php if (!empty($project['project_users_intersted'])): ?>
                                                    <?php foreach ($project['project_users_intersted'] as $user): ?>
                                                        <li class="user-<?= $user->user->id ?> <?= $user->user->fixed ? ' fixed' : '' ?>">
                                                            <div>
                                                                <?php
                                                                $imgUser = empty($user->user->picture) ? $this->Url->build('/front/img/user-default.png', true) : $user->user->picture;
                                                                ?>
                                                                <a href="<?= $this->Url->build('/visualizar-perfil/' . $user->user->id); ?>">
                                                                    <img src="<?= $imgUser; ?>"
                                                                         class="img-responsive">
                                                                    <span class="name"><?= $user->user->name ?></span>
                                                                    <span
                                                                        class="type"><?= empty($user->user->developer_type) ? 'Desenvolvedor' : $user->user->developer_type ?></span>
                                                                </a>
                                                                <?= $this->element('Profile/reputation', ['reputation' => $user->user->reputation, 'display' => false]); ?>
                                                                <?php
                                                                $firstName = explode(' ', $user->user->name);
                                                                ?>
                                                                <?php if (!$user->user->fixed) { ?>
                                                                    <button
                                                                        class="btn-padrao red escolho-voce"
                                                                        data-user="<?= $user->user->id ?>"
                                                                        data-user_name="<?= $firstName[0] ?>"
                                                                        data-project="<?= $project['id'] ?>"
                                                                        <?= $project['already_fixed'] !== '1' ? '' : 'disabled' ?>
                                                                    >
                                                                        QUERO ESTE DEV
                                                                    </button>
                                                                <?php } else { ?>
                                                                    <button
                                                                        class="btn-padrao white"
                                                                    >
                                                                        <i class="fa fa-check-circle"></i> <?= strtoupper($firstName[0]) ?>
                                                                        FOI ESCOLHIDO
                                                                    </button>
                                                                <?php } ?>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <h4 class="italic">Ainda ninguém se interessou por este projeto</h4>
                                                <?php endif; ?>
                                            </ul>
                                        <?php else: ?>
                                            <h4 class="italic">Ainda ninguém se interessou por este projeto</h4>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <aside class="bar-right">
                            <div>
                                <nav class="collapse navbar-collapse">
                                    <ul class="itens">
                                        <li>
                                            <a data-toggle="pill" href="#prazos-<?= $project['id'] ?>"
                                               class="item-set prazos">Prazos</a>
                                        </li>
                                        <li class="active">
                                            <a data-toggle="pill" href="#projeto-<?= $project['id'] ?>"
                                               class="item-set projeto">Projeto</a>
                                        </li>
                                        <li>
                                            <a data-toggle="pill" href="#avaliacao-<?= $project['id'] ?>"
                                               class="item-set avaliacao">Avaliação</a>
                                        </li>
                                        <li>
                                            <a data-toggle="pill" href="#time-line-<?= $project['id'] ?>"
                                               class="item-set time-line">Time
                                                Line</a>
                                        </li>
                                        <?php if ($this->request->session()->read('Auth.User.type') == 'c'): ?>
                                            <li>
                                                <a data-toggle="pill" href="#interested-<?= $project['id'] ?>"
                                                   class="item-set interested">Interessados</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        </aside>
                    </section>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php
echo $this->append('script', $this->Html->script([
    'dist/js/moment',
    'front/js-min/myProjects'
]));
echo $this->append('css', $this->Html->css([
    'front/css/my-projects'
]));
?>