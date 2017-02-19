<div class="row control-page-div">
    <div>
        <a href="<?= $this->Url->build('/', true); ?>" class="control-page">
            página inicial
        </a>
        / <?= $type !== 'freelancer' ? 'contratante' : 'freelancer' ?> / cadastro
    </div>
</div>
<div class="row">
    <section class="section-form">
        <h1 class="welcome-text">Estamos quase lá...</h1>
        <?= $this->Form->create(null, ['id' => 'formUsers', 'autocomplete' => 'off']) ?>
        <input type="hidden" value="<?= $typeText ?>" name="type"/>
        <div class="col-md-12">
            <input type="text" value="<?= $email ?>" class="big-input-user" name="email" id="email" readonly/>
        </div>
        <div class="col-md-12">
            <input type="text" class="big-input-user" placeholder="Nome completo" name="name" id="name"/>
        </div>
        <div class="col-md-6">
            <input type="password" class="big-input-user" placeholder="Senha" name="password" id="password"/>
        </div>
        <div class="col-md-6">
            <input type="password" class="big-input-user" placeholder="Repita a Senha" id="repeat-password"/>
        </div>
        <div class="col-md-12 create-account-div">
            <a href="#" class="create-account">CRIAR CONTA COMO <?= strtoupper($typeText) ?></a>
        </div>
        <div class="col-md-12">
            <p class="rule-inputs">preencha todos os campos</p>
        </div>
        <?= $this->Form->end(); ?>
    </section>
</div>
<?= $this->element('footer'); ?>
<?php
echo $this->append('css', $this->Html->css([
    'front/css/user-add'
]));
echo $this->append('script', $this->Html->script([
    'front/js/formUsers'
]));
?>
