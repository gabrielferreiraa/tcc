<?= $this->Form->create($project, ['id' => 'formProjects', 'type' => 'file']) ?>

<div class="container corpo total-wrapper">
    <div class="row">
        <div class="col-md-12">
            <?= $this->Form->input('titulo', ['label' => 'Titulo do Trabalho', 'class' => 'form-input']) ?>
        </div>
    </div>

    <div class="row fale_projeto">
        <div class="col-md-12">
            <?= $this->Form->input('description', ['label' => 'Fale sobre seu projeto', 'type' => 'textarea', 'class' => 'form-input description', 'autocomplete' => 'off', 'autocorrect' => 'off', 'autocapitalize' => 'off', 'spellcheck' => false]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $this->Form->input('skill._ids', ['label' => 'Habilidades necessárias para este projeto', 'class' => 'form-input', 'empty' => 'Selecione suas habilidades', 'options' => $skills]) ?>
        </div>
        <div class="col-md-6">
            <?= $this->Form->inputText('titulo', ['label' => 'Anexos', 'class' => 'form-input-text']) ?>
            <button type="button" class="btn-padrao" </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $this->Form->input('date_type', ['label' => 'Data final de entrega', 'placeholder' => 'ex: 01/01/2017', 'class' => 'form-input']) ?>
        </div>
        <div class="col-md-4">
            <?= $this->Form->input('titulo', ['label' => 'Orçamento', 'class' => 'form-input']) ?>
        </div>
    </div>
    <div class="row btns">
        <button class="btn btn-padrao"><i class="fa fa-check-circle-o"></i> SALVAR</button>
        <a href="<?= $this->Url->build('/perfil', true); ?>" class="btn btn-padrao">VOLTAR</a>
    </div>





</div>

<?= $this->Form->end(); ?>

<?php
echo $this->append('css', $this->Html->css([
    'front/css/addProjects'
]));
echo $this->append('script', $this->Html->script([
    'dist/js/select2.min',
    'front/js-min/addProjects'
]));
?>


