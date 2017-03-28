<?php foreach ($projects as $project): ?>
    <article class="project">
        <h4 class="title-project"><?= $project->title ?></h4>
        <p class="normal description">
            <?= $project->description; ?>
        </p>
        <h5 class="normal">Orçamento: R$ <?= number_format($project->budget, 2, ',', '.'); ?></h5>

        <div class="footer">
            <a href="<?= $this->Url->build('/detalhe-projeto/' . $project->id, true); ?>" class="btn-padrao">ver
                mais</a>
            <p class="italic"><?= $project->users_intersted == 0 ? 'Nenhum desenvolvedor mostrou interesse' : '<span class="color-red">' . $project->users_intersted . '</span> desenvolvedor mostrou interesse' ?></p>
        </div>
    </article>
<?php endforeach; ?>
