<?php
$userName = explode(' ', $this->request->session()->read('Auth.User.name'));
?>
<?= $this->element('Profile/drawer'); ?>
<div class="content-wrapper">
    <section class="content">
        <?php if ($percentageProfile < 50): ?>
            <?= $this->element('Profile/complete-profile', ['user' => $userName[0]]); ?>
        <?php endif; ?>
        <article class="skills">
            <?= $this->element('Profile/skills', ['skills', $skills]); ?>
        </article>
        <article class="projects">
            <?= $this->element('Profile/projects', ['projects', $projectsUser]); ?>
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
?>
