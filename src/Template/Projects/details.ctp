<section class="content-wrapper">
    <a href="<?= $this->Url->build('/projetos', true); ?>" class="btn-padrao">VOLTAR</a>
    <h2 class="title color-red normal"><?= $project->title ?></h2>
    <p class="normal"><?= $project->description ?></p>
    <h4 class="color-grey normal subtitle">Habilidades</h4>

    <article class="skills">
        <ul class="skills-list light">
            <li>NodeJS</li>
            <li>HTML</li>
        </ul>
    </article>

    <h4 class="color-grey normal subtitle">Anexos</h4>
    <?php if (empty($project->project_files)): ?>
        <span class="italic">Este projeto não possui anexos</span>
    <?php else: ?>
        <span>anexo</span>
    <?php endif; ?>
    <h4 class="color-grey normal subtitle">Entrega Final</h4>
    <h3 class="color-red normal"><?= $project->date_end->i18nFormat('dd/MM/yyyy'); ?></h3>
</section>
<aside class="right-bar">
    <img
        src="<?= $this->Url->build(empty($project->user->picture) ? '/front/img/user-default.png' : $project->user->picture, true); ?>"
        class="img-responsive center-block img-user">
    <h4 class="normal color-red"><?= $project->user->name ?></h4>
    <h5 class="normal color-red">Cadastrado desde <?= $project->user->created_at->i18nFormat('dd/MM/yyyy') ?></h5>
    <?php if ($finishedProjects): ?>
        <h5 class="normal color-red">Já finalizou <?= $finishedProjects ?> projetos </h5>
    <?php endif; ?>

    <?php
    $name = explode(' ', $project->user->name);
    ?>

    <button class="btn-padrao mostrar-interesse">
        MOSTRAR INTERESSE
        <br/>
        <small>no projeto de <?= $name[0] ?></small>
    </button>
    <h5 class="normal color-red budget"><?= $name[0] ?> orçou este projeto em <br/>
        <div>R$ <?= number_format($project->budget, 2, '.', ',') ?></div>
    </h5>
</aside>
<?php
echo $this->append('css', $this->Html->css([
    'front/css/project-details'
]));
?>