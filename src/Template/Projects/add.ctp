<?= $this->Form->create($project, ['id' => 'formProjects', 'type' => 'file']) ?>

<a href="<?= $this->Url->build('/meus-projetos', true); ?>" class="btn-padrao">
    VOLTAR
</a>

<div class="row" style="margin-top: 20px;">
    <div class="col-md-12">
        <?= $this->Form->hidden('status', ['value' => 0]); ?>
        <?= $this->Form->hidden('already_fixed', ['value' => 0]); ?>
        <?= $this->Form->hidden('user_id', ['value' => $this->request->session()->read('Auth.User.id')]); ?>
        <?= $this->Form->input('title', ['label' => 'Titulo do Trabalho', 'class' => 'form-input']) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?= $this->Form->input('description', ['label' => 'Fale sobre seu projeto', 'type' => 'textarea', 'class' => 'form-input description', 'autocomplete' => 'off', 'autocorrect' => 'off', 'autocapitalize' => 'off', 'spellcheck' => false]) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <?= $this->Form->input('skills._ids', ['label' => 'Habilidades necessárias para este projeto', 'class' => 'form-input', 'empty' => 'Selecione suas habilidades', 'options' => $skills]) ?>
    </div>
    <div class="col-md-6">
        <div class="input text">
            <input type="file" name="project_files[]" id="project_files" multiple style="display: none;"/>
            <label>Anexos</label>
            <button type="button" class="btn-padrao btn-anexos">
                SELECIONE O ANEXO
            </button>
            <ul class="files-list"></ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <?= $this->Form->input('date_end', ['label' => 'Data final de entrega', 'placeholder' => 'ex: 01/01/2017', 'class' => 'form-input', 'type' => 'text']) ?>
    </div>
    <div class="col-md-3">
        <?= $this->Form->input('budget', ['label' => 'Orçamento', 'class' => 'form-input', 'type' => 'text']) ?>
    </div>
</div>
<div class="row actions">
    <div class="col-md-12">
        <button class="btn btn-padrao"><i class="fa fa-check-circle-o"></i> SALVAR</button>
    </div>
</div>

<?= $this->Form->end(); ?>

<script>
    var deleteFile = function (file) {
        var files = $('#files-ids')[0].files;

        for (var i in files) {
            if (i !== file) {
                delete $('#files-ids')[0].files[file];
            }
        }
    };
</script>

<?php
echo $this->append('css', $this->Html->css([
    'dist/css/select2.min',
    'front/css/addProjects'
]));
echo $this->append('script', $this->Html->script([
    'dist/js/mask',
    'dist/js/moment',
    'dist/js/select2.min',
    'front/js-min/addProjects'
]));
?>


