<aside>
    <a href="#" class="btn-toggle hidden-lg hidden-sm hidden-md"><i class="fa fa-angle-right"></i></a>
    <section class="profile-informations">
        <div class="div-scrollTop">
            <img src="<?= $userPicture ?>" alt="<?= $userName ?>" title="<?= $userName ?>" class="img-responsive img-user"/>
            <h3 class="name-user"><?= $userName ?></h3>
            <p class="description">
                Breve descrição sobre seu perfil profissional e áreas de atuação
            </p>
            <div class="btn-edit">
                <a href="<?= $this->Url->build('/editar-perfil', true); ?>" class="btn btn-padrao">EDITAR PERFIL</a>
            </div>
            <div class="informations-user">
                <ul class="list-i">
                    <li><i class="fa fa-clock-o"></i><?= ucfirst($userType) ?> desde <?= $user['created_at']->i18nFormat('dd/MM/yyyy'); ?></li>
                </ul>
            </div>
        </div>
    </section>
    <section>

    </section>
</aside>