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
    <div class="row border-top section-form">
        <h4 class="normal">INFORMAÇÕES PESSOAIS</h4>
        <div class="col-md-4 no-padding">
            <?= $this->Form->input('email', ['label' => 'E-mail', 'readonly' => true, 'class' => 'form-input']) ?>
        </div>
        <div class="col-md-4">
            <div class="input">
                <label>Senha</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <input type="password" id="password" name="password" class="form-input" value="<?= $user->password ?>">
                </div>
            </div>
        </div>
        <div class="col-md-4 no-padding">
            <div class="input">
                <label>Repita a Senha</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <input type="password" id="repeat-password" name="repeat-password" class="form-input">
                </div>
            </div>
        </div>
    </div>
    <div class="row border-top section-form">
        <h4 class="normal">ENDEREÇO</h4>
        <div class="col-md-2 col-xs-6 no-padding">
            <?= $this->Form->input('cep', ['label' => 'CEP', 'class' => 'form-input']) ?>
        </div>
        <div class="col-md-2 col-xs-6">
            <button type="button" class="btn-padrao btn-buscar-cep"><i class="fa fa-search"></i> BUSCAR</button>
        </div>
        <div class="col-md-4">
            <?= $this->Form->input('state_id', ['label' => 'Estado', 'class' => 'form-input', 'empty' => 'Selecione o estado']) ?>
        </div>
        <div class="col-md-4 no-padding">
            <?= $this->Form->input('city_id', ['label' => 'Cidade', 'class' => 'form-input', 'empty' => 'Selecione o Estado ou CEP']) ?>
        </div>
        <div class="col-md-6 no-padding">
            <?= $this->Form->input('street', ['label' => 'Rua/Av', 'class' => 'form-input']) ?>
        </div>
        <div class="col-md-2">
            <?= $this->Form->input('number', ['label' => 'Número', 'class' => 'form-input']) ?>
        </div>
        <div class="col-md-4 no-padding">
            <?= $this->Form->input('neighborhood', ['label' => 'Bairro', 'class' => 'form-input']) ?>
        </div>
    </div>
    <div class="row border-top">
        <h4 class="normal">SOCIAL</h4>
        <div class="col-md-3 no-padding">
            <?= $this->Form->input('cel_phone', ['label' => 'Celular', 'class' => 'form-input']) ?>
        </div>
        <div class="col-md-3">
            <div class="input">
                <label>Facebook</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                    <input type="text" id="facebook" name="facebook" class="form-input" placeholder="Usuário do Facebook" value="<?= $user->facebook ?>">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input">
                <label>LinkedIn</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
                    <input type="text" id="linkedin" name="linkedin" class="form-input" placeholder="Usuário do LinkedIn" value="<?= $user->linkedin ?>">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input">
                <label>GitHub</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="fa fa-github"></i></span>
                    <input type="text" id="github" name="github" class="form-input" placeholder="Usuário do Github" value="<?= $user->github ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="row border-top">
        <h4 class="normal">HABILIDADES E BIBLIOGRAFIA</h4>
        <div class="col-md-6 no-padding">
            <?= $this->Form->input('skill._ids', ['label' => 'Me considero ninja em', 'class' => 'form-input', 'empty' => 'Selecione suas habilidades']) ?>
        </div>
        <div class="col-md-6">
            <?= $this->Form->input('description', ['label' => 'Fale um pouco sobre você', 'type' => 'textarea', 'class' => 'form-input']) ?>
        </div>
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
