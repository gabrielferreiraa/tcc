<?php
    $userName = explode(' ', $this->request->session()->read('Auth.User.name'));
?>
<header class="header-site">
    <div class="col-xs-6 action-xs-menu">
        <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu">
            <i class="fa fa-bars"></i>
        </button>
    </div>

    <div class="container">
        <nav class="collapse navbar-collapse menu-top" id="menu">
            <ul class="nav navbar-nav">
                <li class="li-item">
                    <a href="#" class="projects">MEUS PROJETOS</a>
                </li>

                    <?php if($this->request->session()->read('Auth.User.type') == 'c'): ?>
                <li class="li-item">
                    <a href="#" class="find-projects">PROJETOS</a>
                </li>
                    <?php endif; ?>
                <li class="li-item">
                    <?php if($this->request->session()->read('Auth.User.type') == 'f'): ?>
                        <a href="#" class="find-job">PROCURE TRABALHO</a>
                    <?php endif; ?>
                </li>
                <li class="li-item">
                    <a href="#" class="messages">MENSAGENS</a>
                </li>
                <li class="li-item">
                    <a href="#" class="my-profile">MEU PERFIL</a>
                </li>
                <li class="li-item">
                    <a href="<?= $this->Url->build('/sair', true); ?>" class="sign-out">SAIR</a>
                </li>
                <li class="li-picture">
                    <img src="<?= empty($this->request->session()->read('Auth.User.picture')) ? $this->Url->build('/front/img/user-default.png', true) : $this->request->session()->read('Auth.User.picture') ?>" class="profile-picture"/>
                    <span>Olá, <span class="first-name"><?= $userName[0] ?></span></span>
                </li>
            </ul>
        </nav>
    </div>
</header>
<?php
echo $this->append('css', $this->Html->css([
    'front/css/header'
]));
echo $this->fetch('css');
?>