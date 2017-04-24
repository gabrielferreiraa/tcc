<main class="main-content">
    <div class="main-content__img main-content--left"></div>
    <div class="main-content__img main-content--right"></div>

    <a href="<?= $this->Url->build('/login', true); ?>" class="main-content__login">Já é cadastrado ?</a>

    <section class="informations informations-left">
        <h1>Encontre freelancers<br/>especializados<br/>para seu
            negócio</h1>
        <a href="<?= $this->Url->build('/contratante', true); ?>" class="btn-padrao white red">CONTRATAR</a>
    </section>
    <section class="informations informations-right">
        <h1>Procure projetos!<br/>Mostre seu talento!</h1>
        <a href="<?= $this->Url->build('/freelancer', true); ?>" class="btn-padrao white red">TRABALHAR</a>
    </section>
</main>

<?php
echo $this->append('css', $this->Html->css([
    'front/css/home'
]));
echo $this->append('script', $this->Html->script([
    'front/js-min/home'
]));
?>