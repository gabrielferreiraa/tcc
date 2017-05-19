<?php
$userName = explode(' ', $this->request->session()->read('Auth.User.name'));
?>
<?= $this->element('Profile/drawer', ['user' => $user, 'view' => false]); ?>
<div class="content-wrapper">
    <section class="content">
        <article class="top-informations">
            <div class="col-md-4 normal">
                <?php if ($this->request->session()->read('Auth.User.type') == 'c'): ?>
                    <?= $userName[0] . ' já pagou R$<b>' . number_format($totalBudget->total, 2, ',', '.') . '</b>' ?>
                <?php else: ?>
                    <?= $this->element('Profile/reputation', ['reputation' => $reputation]); ?>
                <?php endif; ?>
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
        <?php if ($percentageProfile < 50): ?>
            <?= $this->element('Profile/complete-profile', ['user' => $userName[0]]); ?>
        <?php endif; ?>

        <?= $this->element('Profile/skills', ['skills' => $user['user_skills']]); ?>
        <article class="projects">
            <?= $this->element('Profile/projects', ['projects' => $projectsUser, 'view' => false]); ?>
        </article>
        <?php if ($user['public_address'] == 1): ?>
            <article class="address">
                <?= $this->element('Profile/address', ['user' => $user]); ?>
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
