<img
    src="<?= $userPicture ?>"
    alt="<?= $userName ?>"
    title="<?= $userName ?>"
    class="img-responsive img-user"/>

<?= $this->Form->create($user, ['id' => 'formProfiles', 'type' => 'file']) ?>
<div class="container-fluid content-profile">
    <div class="row">
        <div class="col-md-12">
            <?= $this->Form->input('name', ['label' => false, 'class' => 'name-input']) ?>
        </div>
    </div>
    <div class="row border-top">
        <h4 class="normal">INFORMAÇÕES PESSOAIS</h4>
        <div class="col-md-4">
            <?= $this->Form->input('email', ['label' => 'E-mail', 'readonly' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $this->Form->input('password', ['label' => 'Senha']) ?>
        </div>
        <div class="col-md-4">

        </div>
    </div>
    <div class="row border-top">
        <h4 class="normal">ENDEREÇO</h4>
    </div>
    <div class="row border-top">
        <h4 class="normal">SOCIAL</h4>
    </div>
    <div class="row border-top">
        <h4 class="normal">HABILIDADES E BIBLIOGRAFIA</h4>
    </div>
    <div class="row btns">
        <button class="btn btn-padrao"><i class="fa fa-check-circle"></i> SALVAR</button>
        <a href="<?= $this->Url->build('/perfil', true); ?>" class="btn btn-padrao">VOLTAR</a>
    </div>
</div>
<?= $this->Form->end() ?>

<?php
echo $this->append('css', $this->Html->css([
    'front/css/form-profile'
]));
echo $this->append('script', $this->Html->script([
    'front/js-min/formProfile'
]));
?>
