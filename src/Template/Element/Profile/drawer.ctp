<aside>
    <a href="#" class="btn-toggle hidden-lg hidden-sm hidden-md"><i class="fa fa-angle-right"></i></a>
    <section class="profile-informations">
        <div class="div-scrollTop">
            <?php if ($view): ?>
                <img
                    src="<?= !empty($user['picture']) ? $user['picture'] : $this->Url->build('/front/img/user-default.png', true); ?>"
                    alt="<?= $user['name'] ?>" title="<?= $user['name'] ?>"
                    class="img-responsive img-user"/>
                <h3 class="name-user"><?= $user['name'] ?></h3>
            <?php else: ?>
                <img src="<?= $userPicture ?>" alt="<?= $userName ?>" title="<?= $userName ?>"
                     class="img-responsive img-user"/>
                <h3 class="name-user"><?= $user['name'] ?></h3>
            <?php endif; ?>
            <?php if (!$view): ?>
                <p class="description" title="<?= empty($user['description']) ? '' : $user['description'] ?>">
                    <?php if (!empty($user['description'])): ?>
                        <?= strlen($user['description']) > 150 ? substr($user['description'], 0, 150) . '...' : $user['description'] ?>
                    <?php else: ?>
                        Breve descrição sobre seu perfil profissional e áreas de atuação
                    <?php endif; ?>
                </p>
            <?php endif; ?>
            <div class="btn-edit">
                <?php if (!$view): ?>
                    <a href="<?= $this->Url->build('/editar-perfil', true); ?>" class="btn btn-padrao">EDITAR PERFIL</a>
                <?php else: ?>
                    <a href="javascript:void(0)" class="btn btn-padrao" data-toggle="modal" data-target="#message">
                        <i class="fa fa-envelope-o"></i> MANDAR MENSAGEM
                    </a>
                <?php endif; ?>
            </div>
            <div class="informations-user">
                <ul class="list-i">
                    <li><i class="fa fa-envelope-o"></i> <?= $user['email'] ?></li>
                    <?php if (!empty($user['city'])) { ?>
                        <li>
                            <i class="fa fa-map-marker"></i> <?= $user['city']['name'] . ' / ' . $user['city']['state']['name'] ?>
                        </li>
                    <?php } ?>
                    <li><i class="fa fa-clock-o"></i>Cadastrado
                        desde <?= $user['created_at']->i18nFormat('dd/MM/yyyy'); ?></li>
                    <?php if (!empty($user['facebook'])) { ?>
                        <li><i class="fa fa-facebook-square"></i> <?= $user['facebook'] ?></li>
                    <?php } ?>
                    <?php if (!empty($user['linkedin'])) { ?>
                        <li><i class="fa fa-linkedin-square"></i> <?= $user['linkedin'] ?></li>
                    <?php } ?>
                    <?php if (!empty($user['github'])) { ?>
                        <li><i class="fa fa-github-square"></i> <?= $user['github'] ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </section>
</aside>

<div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    MENSAGEM PARA
                    <span class="upper"><?= $user['name'] ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <span class="italic"><?= $userName ?>, mande uma mensagem para <?= $user['name'] ?></span>
                <div class="post-message">
                    <img src="<?= $userPicture ?>" class="img-responsive">
                    <textarea
                        class="message"
                        placeholder="escreva sua mensagem..."
                        autocomplete="off"
                        autocorrect="off"
                        autocapitalize="off"
                        spellcheck="false"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-padrao send-message" data-id="<?= $user['id'] ?>" disabled><i class="fa fa-paper-plane-o"></i> ENVIAR</button>
            </div>
        </div>
    </div>
</div>