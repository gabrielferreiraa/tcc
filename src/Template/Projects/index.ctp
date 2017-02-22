<?= $this->element('drawer', ['regions' => $regions]); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="input-group">
                <input type="search" class="search-project" placeholder="Pesquise um projeto..."/>
                <span class="input-group-btn">
                <button class="btn btn-search" type="button"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </section>
    </div>
<?php
echo $this->append('css', $this->Html->css([
    'front/css/projects'
]));
echo $this->append('script', $this->Html->script([
    'front/js/formProjects'
]));
?>