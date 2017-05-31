<div class="container">
    <div class="row bar-tasks">
        <button class="button btn-padrao"><i class="fa fa-plus-circle"></i> Adicionar</button>
        <button class="button btn-padrao"><i class="fa fa-trash"></i> Excluir Selecionados</button>
        <button class="button btn-padrao"><i class="fa fa-pencil"></i> Editar</button>
    </div>

    <div class="row table-container">
        <h4 class="normal" style="margin: 15px;">Lista de Habilidades</h4>

        <input type="text" class="input-search-skills" placeholder="Pesquise uma habilidade"
               title="ENTER para pesquisar"/>

        <select class="filterType">
            <option value="front-end">Front-End</option>
            <option value="back-end">Back-End</option>
        </select>

        <div class="table-responsive">
            <table class="table table-condensed tableSkills">
                <thead>
                <tr>
                    <th></th>
                    <th>#ID</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<?php
echo $this->append('css', $this->Html->css([
    'front/css/skillsAdd'
]));
echo $this->append('script', $this->Html->script([
    'front/js-min/skillsAdd'
]));
?>