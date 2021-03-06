<section class="content-wrapper">
    <a href="<?= $this->Url->build('/projetos', true); ?>" class="btn-padrao">VOLTAR</a>
    <h2 class="title color-red normal"><?= $project->title ?></h2>
    <p class="normal"><?= $project->description ?></p>
    <h4 class="color-grey normal subtitle">Habilidades</h4>

    <article class="skills">
        <ul class="skills-list light">
            <?php foreach ($skills as $skill): ?>
                <li><?= $skill->name ?></li>
            <?php endforeach; ?>
        </ul>
    </article>

    <h4 class="color-grey normal subtitle">Anexos</h4>
    <?php if (empty($project->project_files)): ?>
        <span class="italic">Este projeto não possui anexos</span>
    <?php else: ?>
        <ul class="file-list">
            <?= $this->element('Projects/list-file', ['files' => $project->project_files]) ?>
        </ul>
    <?php endif; ?>
    <h4 class="color-grey normal subtitle">Entrega Final</h4>
    <h3 class="color-red normal"><?= $project->date_end->i18nFormat('dd/MM/yyyy'); ?></h3>
</section>
<aside class="right-bar">
    <a href="<?= $this->Url->build('/visualizar-perfil/' . $project->user->id); ?>">
        <?php
        $imgUser = empty($project->user->picture) ? $this->Url->build('/front/img/user-default.png', true) : $project->user->picture;
        ?>
        <img
            src="<?= $imgUser ?>"
            class="img-responsive center-block img-user">
    </a>
    <h4 class="normal color-red"><?= $project->user->name ?></h4>

    <h5 class="normal color-red">Cadastrado desde <?= $project->user->created_at->i18nFormat('dd/MM/yyyy') ?></h5>
    <?php if ($finishedProjects): ?>
        <h5 class="normal color-red">Já finalizou <b><?= $finishedProjects ?></b> projetos </h5>
    <?php endif; ?>

    <?php
    $name = explode(' ', $project->user->name);
    ?>

    <?php if ($this->request->session()->read('Auth.User.type') !== 'c'): ?>
        <button class="btn-padrao mostrar-interesse <?= !empty($alreadyIntersted) ? 'interested' : '' ?>"
                data-id="<?= $project->id ?>">
            <?= !empty($alreadyIntersted) ? '<i class="fa fa-check-circle"></i> Você mostrou interesse' : 'MOSTRAR INTERESSE <br/> <small>no projeto de ' . $name[0] . '</small>' ?>
        </button>
    <?php endif; ?>
    <h5 class="normal color-red budget"><?= $name[0] ?> orçou este projeto em <br/>
        <div>R$ <?= $project->budget; ?></div>
    </h5>
</aside>
<?php
echo $this->append('script', $this->Html->script([
    'front/js-min/formProjects'
]));
echo $this->append('css', $this->Html->css([
    'front/css/project-details'
]));
?>