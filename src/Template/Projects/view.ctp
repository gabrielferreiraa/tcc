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
                                        <?php if ($this->request->session()->read('Auth.User.type') == 'c'): ?>
                                            <?php if ($project['status']['id'] == '1'): ?>
                                                <button
                                                    data-project="<?= $project['id'] ?>"
                                                    class="btn btn-circle open-modal-reputation">
                                                    Finalizar Projeto&nbsp;&nbsp;<i class="fa fa-check"></i>
                                                </button>
                                            <?php endif; ?>
                                        <?php endif; ?>
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
                                    <?php else: ?>

                                    <?php endif; ?>
                                </div>
                                <div id="time-line-<?= $project['id'] ?>" class="tab-pane fade">
                                    <?php if ($project['project_steps']): ?>
                                        <div id="timeline">
                                            <?php foreach ($project['project_steps'] as $keyStep => $step): ?>
                                                <div class="timeline-item">
                                                    <div class="timeline-icon">
                                                        <i class="<?= $step->icon ?>"></i>
                                                    </div>
                                                    <div
                                                        class="timeline-content <?= $keyStep % 2 == 0 ? 'right' : 'left' ?>">
                                                        <h2><?= strtoupper($step->title) ?></h2>
                                                        <p>
                                                            <?= $step->description ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
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
            <?php if (($project['status']['id'] == '1') && (!empty($dev))): ?>
                <?php
                $content = '<h3 class="normal text-center">Antes de finalizarmos...</h3><br/>';
                ?>
                <?=
                $this->element('modal-default', [
                    'content' => $content . $this->element('stars-interaction') . '</br> <h3 class="rate text-center bold"></h3>',
                    'id' => 'reputation-' . $project['id'],
                    'textBtn' => 'AVALIAR USUÁRIO',
                    'titleHead' => $this->request->session()->read('Auth.User.name') . ', qual nota você daria para <a href="' . $this->Url->build('/visualizar-perfil/' . $dev->user->id, true) . '" class="bold">' . $dev->user->name . '</a> ?',
                    'btnClass' => 'finishProject',
                    'attrs' => [
                        'data-project' => $project['id']
                    ]
                ]);
                ?>
            <?php endif; ?>
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