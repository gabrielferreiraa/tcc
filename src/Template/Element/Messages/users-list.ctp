<?php if (isset($participants)): ?>
    <?php if ($participants->count()): ?>
        <div class="row">
            <div class="col-md-12">
                <ul class="participants-list">
                    <?php foreach ($participants as $participant): ?>
                        <li class="participant-list participant-<?= $participant->id ?>"
                            data-id="<?= $participant->id ?>">
                            <img
                                src="<?= empty($participant->picture) ? $this->Url->build('/front/img/user-default.png', true) : $participant->picture ?>"
                                class="img-responsive">
                            <div class="name">
                                <?= $participant->name ?>
                            </div>
                            <div class="user-type"><?= $participant->type == 'f' ? 'FREELANCER' : 'CONTRATANTE' ?></div>
                            <div class="email">
                                <?= $participant->email ?>
                            </div>
                            <?php if (!empty($participant->developer_type)): ?>
                                <div class="developer">
                                    <?= $participant->developer_type ?>
                                </div>
                            <?php else: ?>
                                <div class="developer">
                                    Desenvolvedor(a)
                                </div>
                            <?php endif; ?>
                            <?php
                            $atualName = explode(' ', $participant->name);
                            ?>
                            <a href="<?= $this->Url->build('/visualizar-perfil/' . $participant->id, true); ?>"
                               class="btn-padrao profile"><i class="fa fa-user-circle"></i> PERFIL
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="row paginator">
            <?= $this->element('paginator'); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>