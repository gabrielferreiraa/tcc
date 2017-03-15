<?php $onlineUser = $this->request->session()->read('Auth.User.id'); ?>
<?php if ($messages->count()): ?>
    <div class="container wrapper-all">
        <div class="wrapper">
            <section class="content">
                <aside>
                    <ul class="contacts">
                        <?php foreach ($messages as $indicators): ?>
                            <?php
                            $userType = $onlineUser == $indicators->users_to->id ? 'users_from' : 'users_to';
                            $imageUserMessage = !empty($indicators->{$userType}->picture) ? $this->Url->build($indicators->{$userType}->picture, true) : $this->Url->build('/front/img/user-default.png', true);
                            ?>
                            <a href="#<?= $indicators->id ?>">
                                <li>
                                    <img src="<?= $imageUserMessage ?>"/>
                                    <span class="hidden-xs">
                                    <?= $indicators->{$userType}->name ?>
                                </span>
                                    <?php
                                    if (date('Y-m-d') == $indicators->date->i18nFormat('YYYY-MM-dd')) {
                                        ?>
                                        <span
                                            class="hidden-xs">última mensagem as <?= $indicators->date->i18nFormat('H:mm'); ?></span>
                                        <?php
                                    } else {
                                        ?>
                                        <span
                                            class="hidden-xs">última mensagem dia <?= $indicators->date->i18nFormat('dd/MM'); ?></span>
                                        <?php
                                    }
                                    ?>
                                    <i class="fa fa-circle online"></i>
                                </li>
                            </a>
                        <?php endforeach; ?>
                    </ul>
                </aside>
                <?php $c = 0; ?>
                <?php foreach ($messages as $message): ?>
                    <?php
                    $userType = $onlineUser == $message->users_to->id ? 'users_from' : 'users_to';
                    $imageUserMessage = !empty($message->{$userType}->picture) ? $this->Url->build($message->{$userType}->picture, true) : $this->Url->build('/front/img/user-default.png', true);
                    ?>
                    <section id="<?= $message->id ?>" data-message="<?= $message->id ?>" class="messages-text">
                        <div class="user-informations">
                            <img src="<?= $imageUserMessage ?>"
                                 class="img-responsive img-user-message hidden-md hidden-lg hidden-sm">
                            <h1><?= $message->{$userType}->name ?></h1>
                        </div>
                        <?php foreach ($message->message_records as $record) { ?>
                            <?php if ($record->user_id == $onlineUser): ?>
                                <div class="row">
                                    <div class="bubble-right">
                                        <div class="informations">
                                            <p>
                                                <?= $record->text ?>
                                            </p>
                                            <i class="italic">
                                                <span class="green-check fa fa-check"></span>
                                                <?= $record->created->i18nFormat('HH:mm'); ?>
                                            </i>
                                        </div>
                                        <figure>
                                            <img src="<?= $userPicture ?>"/>
                                        </figure>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <div class="bubble-left">
                                        <figure>
                                            <img src="<?= $imageUserMessage ?>"/>
                                        </figure>
                                        <div class="informations">
                                            <p>
                                                <?= $record->text ?>
                                            </p>
                                            <i class="italic"><?= $record->created->i18nFormat('H:mm'); ?></i>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php } ?>
                    </section>
                    <?php $c++; ?>
                <?php endforeach; ?>
            </section>
            <section class="message">
                <input
                    type="text"
                    id="message"
                    class="new-message"
                    autocomplete="off"
                    autocorrect="off"
                    autocapitalize="off"
                    spellcheck="false"
                    placeholder="Escreva sua mensagem..."/>
                <button id="send" class="send-message">Enviar</button>
            </section>
        </div>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col-md-12 wrapper-no-message">
            <i class="fa fa-comments-o"></i>
            <h3>Você ainda não possui nenhuma conversa</h3>

            <form id="formSearch">
                <input
                    type="search"
                    class="input-search"
                    autocomplete="off"
                    autocorrect="off"
                    autocapitalize="off"
                    spellcheck="false"
                    name="search"
                    value="<?= $this->request->query('search'); ?>">
                <p class="italic">Procure por alguém...</p>
                <button type="submit" class="btn btn-padrao">BUSCAR</button>
            </form>
        </div>
    </div>
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
                                <div class="email">
                                    <?= $participant->email ?>
                                </div>
                                <?php if (!empty($participant->developer_type)): ?>
                                    <div class="developer">
                                        <?= $participant->developer_type ?>
                                    </div>
                                <?php endif; ?>
                                <?php
                                $atualName = explode(' ', $participant->name);
                                ?>
                                <?php if (!empty($participant->city)): ?>
                                    <div class="address">
                                        <?= $participant->city->name . ' / ' . $participant->city->state->state_cod ?>
                                    </div>
                                <?php endif; ?>
                                <a href="<?= $this->Url->build('/visualizar-perfil/' . $participant->id, true); ?>" class="btn-padrao profile"><i class="fa fa-user-circle"></i> PERFIL
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
<?php endif; ?>
    <script>
        var userPicture = '<?= $userPicture ?>';
    </script>
<?php
echo $this->append('css', $this->Html->css([
    'front/css/messages'
]));
echo $this->append('script', $this->Html->script([
    'dist/js/moment',
    'front/js-min/messages'
]));
?>