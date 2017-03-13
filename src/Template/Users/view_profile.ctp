<?= $this->element('Profile/drawer', ['user' => $user, 'view' => true]); ?>
<div class="content-wrapper">
    <section class="content">
        <article class="top-informations">
            <div class="col-md-4">
                <h3>Reputação:
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                    <i class="fa fa-star-o"></i>
                </h3>
            </div>
            <div class="col-md-4">
                <h3>Projetos Finalizados <span><?= $finishedProjects ?></span></h3>
            </div>
            <?php if (!empty($user['developer_type'])): ?>
                <div class="col-md-4">
                    <h3><?= $user['developer_type'] ?></h3>
                </div>
            <?php endif; ?>
        </article>
        <?= $this->element('Profile/skills', ['skills', $skills]); ?>
        <article class="projects">
            <?= $this->element('Profile/projects', ['projects', $projectsUser, 'view' => $user['name']]); ?>
        </article>
        <?php if (!empty($this->request->session()->read('Auth.User.public_address'))): ?>
            <article class="address">
                <?= $this->element('Profile/address'); ?>
            </article>
        <?php endif; ?>
    </section>
</div>
<?php
echo $this->append('css', $this->Html->css([
    'front/css/profile'
]));
echo $this->append('script', $this->Html->script([
    'front/js-min/profile'
]));
?>
