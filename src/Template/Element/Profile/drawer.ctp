<aside>
    <a href="#" class="btn-toggle hidden-lg hidden-sm hidden-md"><i class="fa fa-angle-right"></i></a>
    <section class="profile-informations">
        <div class="div-scrollTop">
            <img src="<?= $userPicture ?>" alt="<?= $userName ?>" title="<?= $userName ?>" class="img-responsive img-user"/>
            <h3 class="name-user"><?= $userName ?></h3>
            <p class="description">
                <?php if(!empty($user['description'])): ?>
                    <?= $user['description'] ?>
                    <?php else: ?>
                    Breve descrição sobre seu perfil profissional e áreas de atuação
                <?php endif; ?>
            </p>
            <div class="btn-edit">
                <a href="<?= $this->Url->build('/editar-perfil', true); ?>" class="btn btn-padrao">EDITAR PERFIL</a>
            </div>
            <div class="informations-user">
                <ul class="list-i">
                    <?php if(!empty($user['city'])){ ?>
                        <li><i class="fa fa-map-marker"></i> <?= $user['city'] . ' / ' . $user['state'] ?></li>
                    <?php } ?>
                    <li><i class="fa fa-clock-o"></i><?= ucfirst($userType) ?> desde <?= $user['created_at']->i18nFormat('dd/MM/yyyy'); ?></li>
                    <?php if(!empty($user['facebook'])){ ?>
                        <li><i class="fa fa-facebook-square"></i> <?= $user['facebook'] ?></li>
                    <?php } ?>
                    <?php if(!empty($user['linkedin'])){ ?>
                        <li><i class="fa fa-linkedin-square"></i> <?= $user['linkedin'] ?></li>
                    <?php } ?>
                    <?php if(!empty($user['github'])){ ?>
                        <li><i class="fa fa-github-square"></i> <?= $user['github'] ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </section>
</aside>