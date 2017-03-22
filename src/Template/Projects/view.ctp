<?php if ($projects->count()): ?>
    <div class="panel-group" id="accordion">
        <?php foreach ($projects as $project): ?>
            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion"
                     href="#collapse<?= $project->id ?>">
                    <div class="status">
                        <?php if ($project->status == 0): ?>
                            <div class="andamento">
                                <i class="fa fa-clock-o"></i>
                                <span>ANDAMENTO</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h4 class="panel-title">
                        <?= $project->title ?>
                    </h4>
                </div>
                <div id="collapse<?= $project->id ?>" class="panel-collapse collapse in">
                    <section class="content">
                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="prazos" class="tab-pane fade">
                                    <h4 class="normal">Prazo final para entrega:
                                        <?= $project->date_end->i18nFormat('dd/MM/yyyy'); ?>
                                    </h4>
                                </div>
                                <div id="projeto" class="tab-pane fade in active projeto">
                                    <div class="top-informations">
                                        <span>Orçamento: R$ <?= number_format($project->budget, 2, '.', ',') ?></span>
                                        <button class="btn btn-circle open-partner"><i class="fa fa-user"></i></button>
                                        <button class="btn btn-circle open-anexo"><i class="fa fa-paperclip"></i>
                                        </button>
                                    </div>
                                    <div class="skills">
                                        <span class="normal">Habilidades Necessárias:</span>
                                        <ul class="skills-list light">
                                            <li>NodeJS</li>
                                            <li>HTML</li>
                                        </ul>
                                    </div>
                                    <div class="description">
                                        <span class="normal">Descrição:</span>
                                        <p class="normal">
                                            <?= $project->description ?>
                                        </p>
                                    </div>
                                </div>
                                <div id="avaliacao" class="tab-pane fade">
                                    <?php if ($project->status === 0): ?>
                                        <h4 class="italic">Você ainda não finalizou este projeto</h4>
                                    <?php endif; ?>
                                </div>
                                <div id="time-line" class="tab-pane fade">
                                    <h3>TIME LINE</h3>
                                </div>
                            </div>
                        </div>
                        <aside class="bar-right">
                            <div>
                                <nav class="collapse navbar-collapse">
                                    <ul class="itens">
                                        <li>
                                            <a data-toggle="pill" href="#prazos" class="item-set prazos">Prazos</a>
                                        </li>
                                        <li class="active">
                                            <a data-toggle="pill" href="#projeto" class="item-set projeto">Projeto</a>
                                        </li>
                                        <li>
                                            <a data-toggle="pill" href="#avaliacao"
                                               class="item-set avaliacao">Avaliação</a>
                                        </li>
                                        <li>
                                            <a data-toggle="pill" href="#time-line" class="item-set time-line">Time
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
echo $this->append('css', $this->Html->css([
    'front/css/my-projects'
]));
?>