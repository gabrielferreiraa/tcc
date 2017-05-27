<?php if (count($projects)): ?>
    <?php if ($this->request->session()->read('Auth.User.type') == 'c'): ?>
        <?= $this->element('Projects/btn-cadastrar-projeto'); ?>
    <?php endif; ?>
    <div class="panel-group" id="accordion">
        <?php foreach ($projects as $project): ?>
            <?php
            $dev = isset($project['project_users_fixed']) && !empty($project['project_users_fixed']) ? $project['project_users_fixed'][0] : '';
            ?>
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
                                        <span>Orçamento: R$ <?= $project['budget'] ?></span>
                                        <?php if ($this->request->session()->read('Auth.User.type') == 'c'): ?>
                                            <?php if (!empty($dev)): ?>
                                                <button
                                                    data-dev="<?= $dev['user_id'] ?>-freelancer"
                                                    data-project="<?= $project['id'] ?>"
                                                    class="btn btn-circle open-partner">
                                                    Freelancer escolhido&nbsp;&nbsp;
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <button
                                                data-dev="<?= $project['user_id'] ?>-contractor"
                                                data-project="<?= $project['id'] ?>"
                                                class="btn btn-circle open-partner">
                                                Contratante deste projeto&nbsp;&nbsp;
                                                <i class="fa fa-user"></i>
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
                                                <button class="btn-padrao white">
                                                    VISUALIZAR PERFIL
                                                </button>
                                            </div>
                                        </div>

                                        <?php if (count($project['project_files'])): ?>
                                            <button
                                                data-project="<?= $project['id'] ?>"
                                                class="btn btn-circle open-anexo">
                                                <i class="fa fa-paperclip"></i>
                                            </button>
                                        <?php endif; ?>
                                        <?php if ($this->request->session()->read('Auth.User.type') == 'c'): ?>
                                            <?php if ($project['status']['id'] == '1'): ?>
                                                <button
                                                    data-project="<?= $project['id'] ?>"
                                                    class="btn btn-circle open-modal-reputation">
                                                    Finalizar Projeto&nbsp;&nbsp;
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="skills">
                                        <span class="normal">Habilidades Necessárias:</span>
                                        <?php if (count($project['project_skills'])): ?>
                                            <ul class="skills-list light">
                                                <?php foreach ($project['project_skills'] as $skill): ?>
                                                    <li>
                                                        <?= $skill->skill->name ?>
                                                    </li>
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
                                        <?php if (count($project['user_reputations'])): ?>
                                            <div class="text-center">
                                                <?php if ($this->request->session()->read('Auth.User.type') == 'c'): ?>
                                                    <?php if (!empty($dev)): ?>
                                                        <?php $avaliation = ''; ?>
                                                        <?php foreach ($project['user_reputations'] as $rep): ?>
                                                            <?php if ($rep->user_id == $project->user_id): ?>
                                                                <?php $avaliation = $rep->avaliation; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>

                                                        <?php if (!empty($avaliation)): ?>
                                                            <span class="normal">
                                                                Veja o que <?= $dev['user']['name'] ?> falou sobre você:
                                                            </span>
                                                            <p class="italic">
                                                                "<?= $avaliation ?>"
                                                            </p>
                                                        <?php else: ?>
                                                            <p class="normal"><?= $dev['user']['name'] ?>, ainda não te
                                                                avaliou !</p>

                                                            <p class="italic">
                                                                Mande uma mensagem para
                                                                <?= $dev['user']['name'] ?>,
                                                                e pessa para ele avaliar como é trabalhar em parceria
                                                                com você :)
                                                            </p>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <?php
                                                    $isAvaliable = false;
                                                    $avaliation = '';
                                                    ?>
                                                    <?php foreach ($project['user_reputations'] as $rep): ?>
                                                        <?php if ($rep->user_id == $project->user_id): ?>
                                                            <?php $isAvaliable = true; ?>
                                                        <?php endif; ?>

                                                        <?php if ($rep->user_id == $this->request->session()->read('Auth.User.id')): ?>
                                                            <?php $avaliation = $rep->avaliation; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>

                                                    <?php if (!empty($avaliation)): ?>
                                                        <span class="normal">
                                                            Você foi avaliado por <b><?= $project['contractor'] ?></b> com <br/>
                                                        </span>
                                                        <?= $this->element('Profile/reputation', ['reputation' => $project['user_reputations'][0], 'display' => false]) ?>

                                                        <p class="italic">
                                                            "<?= $avaliation ?>"
                                                        </p>
                                                    <?php else: ?>
                                                        <p class="normal"><?= $project['contractor'] ?>, ainda não te
                                                            avaliou !</p>

                                                        <p class="italic">
                                                            Mande uma mensagem para
                                                            <?= $project['contractor'] ?>,
                                                            e pessa para ele avaliar como é trabalhar em parceria
                                                            com você :)
                                                        </p>
                                                    <?php endif; ?>

                                                    <?php if (!$isAvaliable): ?>
                                                        <div class="text-right">
                                                                <textarea
                                                                    style="margin-top:30px;"
                                                                    class="avaliation avaliation-freelancer-<?= $project->id ?>"
                                                                    placeholder="Aproveite e conte-nos como foi trabalhar com <?= $project->contractor ?>"></textarea>
                                                            <button
                                                                data-project="<?= $project->id ?>"
                                                                data-contractor="<?= $project->user_id ?>"
                                                                type="button"
                                                                class="btn-padrao avaliarContratante">
                                                                AVALIAR CONTRATANTE
                                                            </button>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
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
                                                                        class="type">
                                                                        <?= empty($user->user->developer_type) ? 'Desenvolvedor' : $user->user->developer_type ?>
                                                                    </span>
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
                <?php if (count($project['project_files'])): ?>
                    <?=
                    $this->element('modal-default', [
                        'content' => '<ul class="file-list full">' . $this->element('Projects/list-file', ['files' => $project['project_files'], 'showAll' => true]) . ' </ul>',
                        'id' => 'project-file-' . $project['id'],
                        'textBtn' => 'FECHAR',
                        'btnClose' => true,
                        'titleHead' => 'ARQUIVOS ANEXADOS NESTE PROJETO',
                        'btnClass' => ''
                    ]);
                    ?>
                <?php endif; ?>
            </div>
            <?php if (($project['status']['id'] == '1') && (!empty($dev))): ?>
                <?php
                $content = '<h3 class="normal text-center">Antes de finalizarmos...</h3><br/>';
                ?>
                <?=
                $this->element('modal-default', [
                    'content' =>
                        $content .
                        $this->element('stars-interaction') .
                        '</br> <h3 class="rate text-center bold"></h3>' .
                        "<textarea class='avaliation avaliation-{$project['id']}' placeholder='Conte-nos um pouco de como foi trabalhar com {$dev->user->name}'></textarea>",
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
<?php else: ?>
    <div class="noProjects text-center">
        <h3 class="normal"><b><?= $userName ?></b>,<br/><span class="italic">Você ainda não criou nenhum projeto</span>
        </h3>
        <a href="<?= $this->Url->build('/adicionar-projeto', true); ?>" class="btn-padrao">
            <i class="fa fa-plus-circle"></i> CRIAR PROJETO
        </a>
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