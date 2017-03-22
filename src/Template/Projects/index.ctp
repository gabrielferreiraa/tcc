<?= $this->element('drawer', ['regions' => $regions, 'skills' => $skillsLimited]); ?>
    <div class="content-wrapper">
        <section class="content">
            <form>
                <div class="input-group">
                        <input 
                            type="search" 
                            class="search-project" 
                            name="project-name" 
                            value="<?= $this->request->query('project-name') ?>"
                            placeholder="Pesquise um projeto..." />
                        <span class="input-group-btn">
                            <button class="btn btn-search" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                </div>
            </form>
            <?php if(!empty($this->request->query('project-name'))): ?>
                <?php if(count($projects) == 0): ?>
                    <?php $text = 'Não encontramos resultados para '; ?>
                <?php elseif(count($projects) == 1): ?> 
                    <?php $text = 'Encontramos 1 resultado para ';?>
                <?php else: ?>    
                    <?php $text = 'Encontramos '. count($projects) .' resultadoss para ';?>
                <?php endif; ?>
            <?php else: ?>
                <?php $text = ''; ?>
            <?php endif; ?>
            <span class="result-search">
                <?= $text ?>
                <span>
                    <?= $this->request->query('project-name') ?>
                </span>
            </span>
        </section>
    </div>
<?php
echo $this->append('css', $this->Html->css([
    'front/css/projects'
]));
echo $this->append('script', $this->Html->script([
    'front/js-min/formProjects'
]));
?>