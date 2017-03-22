<?php foreach ($projects as $project): ?>
    <h4 class="title-project"><?= $project->title ?></h4>
    <p class="normal description">
        <?= $project->description; ?>
    </p>
    <h5 class="normal">Orçamento: R$ <?= number_format($project->budget, 2, ',', '.'); ?></h5>

    <div class="footer">
        <a href="#" class="btn-padrao">ver mais</a>
        <p class="italic"><?= $project->users_intersted == 0 ? 'Nenhum desenvolvedor mostrou interesse' : $project->users_intersted . ' mostrou interesse' ?></p>
    </div>
<?php endforeach; ?>
