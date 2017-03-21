<aside class="left-bar">
    <form id="formFilter">
        <div class="scroll-div">
            <section class="dev-area">
                <?= $this->element('Projects/dev-area'); ?>
            </section>
            <section class="skills">
                <?= $this->element('Projects/skills', ['skills' => $skills]); ?>
            </section>
            <section class="region">
                <?= $this->element('Projects/regions', ['regions' => $regions]); ?>
            </section>
            <section class="budget">
                <?= $this->element('Projects/budget'); ?>
            </section>
            <button type="submit" class="btn btn-padrao btn-filter"><i class="fa fa-search"></i> filtrar</button>
        </div>
    </form>
</aside>
<?php
echo $this->append('css', $this->Html->css([
    'front/css/drawer'
]));
?>