<figure>
    <img
        src="<?= $userPicture ?>"
        alt="<?= $userName ?>"
        title="<?= $userName ?>"
        class="img-responsive img-user"/>
    <i class="fa fa-camera"></i>
</figure>

<?= $this->Form->create($user, ['id' => 'formProfiles', 'type' => 'file']) ?>
<input type="file" style="display: none" name="picture-image" id="picture-image"
       accept="image/x-png,image/gif,image/jpeg">
<input type="hidden" name="picture" id="picture"/>
<div class="container-fluid content-profile">
    <div class="row">
        <div class="col-md-12">
            <?= $this->Form->input('name', ['label' => false, 'class' => 'name-input']) ?>
        </div>
    </div>
    <div class="row border-top section-form">
        <h4 class="normal">INFORMAÇÕES PESSOAIS</h4>
        <div class="col-md-4 ">
            <?= $this->Form->input('email', ['label' => 'E-mail', 'readonly' => true, 'class' => 'form-input']) ?>
        </div>
        <div class="col-md-4">
            <div class="input">
                <label>Senha</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <input type="password" id="password" name="password" class="form-input"
                           value="<?= $user->password ?>">
                </div>
            </div>
        </div>
        <div class="col-md-4 ">
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
        <div class="col-md-2 col-xs-6 ">
            <?= $this->Form->input('cep', ['label' => 'CEP', 'class' => 'form-input']) ?>
        </div>
        <div class="col-md-2 col-xs-6">
            <button type="button" class="btn-padrao btn-buscar-cep"><i class="fa fa-search"></i> BUSCAR</button>
        </div>
        <div class="col-md-4">
            <?= $this->Form->input('state_id', ['label' => 'Estado', 'class' => 'form-input', 'empty' => 'Selecione o estado', 'options' => $states]) ?>
        </div>
        <div class="col-md-4 ">
            <?= $this->Form->input('city_id', ['label' => 'Cidade', 'class' => 'form-input', 'empty' => 'Selecione o Estado ou CEP']) ?>
        </div>
        <div class="col-md-6 ">
            <?= $this->Form->input('street', ['label' => 'Rua/Av', 'class' => 'form-input']) ?>
        </div>
        <div class="col-md-2">
            <?= $this->Form->input('number', ['label' => 'Número', 'class' => 'form-input']) ?>
        </div>
        <div class="col-md-4 ">
            <?= $this->Form->input('neighborhood', ['label' => 'Bairro', 'class' => 'form-input']) ?>
        </div>
        <div class="col-md-12">
            <label class="check-type top-margin">
                <input type="checkbox" name="public_address"
                       class="input-checkbox" <?= $user->public_address == 1 ? 'checked' : '' ?> />
                <div class="wrap-check"></div>
                Desejo tornar meus dados de endereço público
            </label>
        </div>
    </div>
    <div class="row border-top">
        <h4 class="normal">SOCIAL</h4>
        <div class="col-md-3 ">
            <?= $this->Form->input('cel_phone', ['label' => 'Celular', 'class' => 'form-input']) ?>
        </div>
        <div class="col-md-3">
            <div class="input">
                <label>Facebook <small class="pull-right">Ex: projetotcc</small></label>
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                    <input type="text" id="facebook" name="facebook" class="form-input"
                           placeholder="Usuário do Facebook" value="<?= $user->facebook ?>">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input">
                <label>LinkedIn <small class="pull-right">Ex: projetotcc</small></label>
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
                    <input type="text" id="linkedin" name="linkedin" class="form-input"
                           placeholder="Usuário do LinkedIn" value="<?= $user->linkedin ?>">
                </div>
            </div>
        </div>
        <div class="col-md-3 ">
            <div class="input">
                <label>GitHub <small class="pull-right">Ex: projetotcc</small></label>
                <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="fa fa-github"></i></span>
                    <input type="text" id="github" name="github" class="form-input" placeholder="Usuário do Github"
                           value="<?= $user->github ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="row border-top">
        <h4 class="normal">HABILIDADES E BIBLIOGRAFIA</h4>
        <div class="col-md-6" style="display: <?= $user['type'] == 'f' ? 'block' : 'none' ?>">
            <?= $this->Form->input('skills._ids', ['label' => 'Me considero ninja em', 'class' => 'form-input', 'empty' => 'Selecione suas habilidades', 'options' => $skills]) ?>
        </div>
        <div class="<?= $user['type'] == 'f' ? 'col-md-6' : 'col-md-12' ?>">
            <?= $this->Form->input('description', ['label' => 'Fale um pouco sobre você', 'type' => 'textarea', 'class' => 'form-input description', 'autocomplete' => 'off', 'autocorrect' => 'off', 'autocapitalize' => 'off', 'spellcheck' => false]) ?>
        </div>
    </div>
    <?php if ($user['type'] == 'f'): ?>
        <div class="row">
            <div class="col-md-4" style="margin-left: 40px;">
                <?= $this->Form->input('developer_type', ['label' => 'Você é um desenvolvedor', 'placeholder' => 'ex: Desenvolvedor Sênior', 'class' => 'form-input']) ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="row btns">
        <button class="btn btn-padrao"><i class="fa fa-check-circle-o"></i> SALVAR</button>
        <a href="<?= $this->Url->build('/perfil', true); ?>" class="btn btn-padrao">VOLTAR</a>
    </div>
</div>
<?= $this->Form->end() ?>

<?php
echo $this->append('css', $this->Html->css([
    'dist/css/select2.min',
    'front/css/form-profile'
]));
echo $this->append('script', $this->Html->script([
    'dist/js/mask',
    'dist/js/select2.min',
    'front/js-min/formProfile'
]));
?>
