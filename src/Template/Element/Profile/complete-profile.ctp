<article class="complete-profile">
    <div class="message">
        <h3><?= $user ?>, complete seu cadastro</h3>
    </div>
    <span class="italic">seu perfil está</span>
    <div class="progress">
        <div
            class="progress-bar"
            role="progressbar"
            aria-valuenow="<?= $percentageProfile ?>"
            aria-valuemin="0"
            aria-valuemax="100"
            style="width: <?= $percentageProfile ?>%;">
            <span><?= $percentageProfile ?>%</span>
        </div>
    </div>
    <a href="<?= $this->Url->build('/editar-perfil', true); ?>" class="btn btn-padrao btn-completar">COMPLETAR PERFIL</a>
</article>