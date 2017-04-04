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
                                        <button class="btn btn-circle open-partner"><i class="fa fa-user"></i></button>
                                        <button class="btn btn-circle open-anexo"><i class="fa fa-paperclip"></i>
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
                                    <h3>TIME LINE</h3>
                                </div>
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